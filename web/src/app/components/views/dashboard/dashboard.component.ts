import { Component, OnInit } from '@angular/core';
import { ConfirmationService, MenuItem, MessageService } from 'primeng/api';
import { Router } from '@angular/router';

import { UserService } from '../../../services/user.service';

import { User } from '../../../models/user.model';
import { JwtService } from '../../../services/jwt.service';

import { Quote } from '../../../models/quote.model';
import { QuoteService } from '../../../services/quote.service';

@Component({
  selector: 'app-dashboard',
  templateUrl: './dashboard.component.html',
  styleUrl: './dashboard.component.css',
  providers: [MessageService, ConfirmationService]
})
export class DashboardComponent implements OnInit {
  public items: MenuItem[] = []
  public user: User<any> = {};
  public quotes: Quote<any> = [];
  public hasNextPage: boolean = false;
  public page: number = 1;

  constructor(
    private userService: UserService, private router: Router, private messageService: MessageService,
    private jwtService: JwtService, private quoteService: QuoteService, private confirmationService: ConfirmationService
  ) { }

  private loadQuotes() {
    this.quoteService.getQuotes(this.page).subscribe((quote: any) => {
      this.quotes = quote.data;
      this.hasNextPage = quote.data.hasNext;
    });
  }

  public previousPage() {
    if (this.page > 1) {
      this.page--;
      this.loadQuotes();
    }
  }

  public nextPage() {
    if (this.hasNextPage) {
      this.page++;
      this.loadQuotes();
    }
  }

  ngOnInit() {
    this.userService.getUser().subscribe((user: User<any>) => {
      this.user = user;
    });

    this.loadQuotes();

    this.items = [
      {
        label: 'Home',
        icon: 'pi pi-fw pi-home',
        routerLink: '/'
      },
      {
        label: 'Create Quote',
        icon: 'pi pi-fw pi-plus',
        routerLink: '/dashboard/quote/create'
      },
      {
        label: 'Profile',
        icon: 'pi pi-fw pi-user',
        items: [
          {
            label: 'Dashboard',
            icon: 'pi pi-fw pi-chart-bar',
            routerLink: '/dashboard'
          },
          {
            label: 'Logout',
            icon: 'pi pi-fw pi-sign-out',
            command: () => {
              this.jwtService.removeToken()
              window.location.href = '/'
            }
          }
        ]
      },
      {
        label: 'Contact',
        icon: 'pi pi-fw pi-envelope',
        items: [
          {
            label: 'Instagram',
            icon: 'pi pi-fw pi-instagram',
            url: 'https://www.instagram.com/ericneves_dev',
            target: '_blank'
          },
          {
            label: 'GitHub',
            icon: 'pi pi-fw pi-github',
            url: 'https://github.com/ericneves',
            target: '_blank',
          },
          {
            label: 'LinkedIn',
            icon: 'pi pi-fw pi-linkedin',
            url: 'https://www.linkedin.com/in/ericnevesrr',
            target: '_blank'
          }
        ]
      },
    ]
  }

  public onDelete(event: any, id: any) {
    this.confirmationService.confirm({
      target: event.target as EventTarget,
      message: 'Do you want to delete this record?',
      header: 'Delete Confirmation',
      icon: 'pi pi-info-circle',
      acceptButtonStyleClass: "p-button-danger p-button-text",
      rejectButtonStyleClass: "p-button-text p-button-text",
      acceptIcon: "none",
      rejectIcon: "none",
      accept: () => {
        this.quoteService.deleteQuote(id).subscribe({
          next: (response: any) => {
            this.messageService.add({ severity: 'success', summary: 'Confirmed', detail: response.message });

            this.loadQuotes();
          },
          error: (error: any) => {
            this.messageService.add({ severity: 'error', summary: 'Error', detail: error.error.message });
          }
        })
      },
    })
  }
}
