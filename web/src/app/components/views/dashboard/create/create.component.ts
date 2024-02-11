import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { MenuItem, MessageService } from 'primeng/api';

import { QuoteService } from '../../../../services/quote.service';
import { JwtService } from '../../../../services/jwt.service';
import { User } from '../../../../models/user.model';
import { Quote } from '../../../../models/quote.model';
import { UserService } from '../../../../services/user.service';

@Component({
  selector: 'app-create',
  templateUrl: './create.component.html',
  styleUrl: './create.component.css',
  providers: [MessageService]
})
export class CreateComponent implements OnInit {
  public items: MenuItem[] = []
  public quote: Quote<any> = {
    author: '',
    quote: ''
  };

  public disabled: boolean = false;

  constructor(
    private messageService: MessageService, private userService: UserService,
    private jwtService: JwtService, private quoteService: QuoteService
  ) { }

  ngOnInit() {
    this.userService.getUser().subscribe((user: any) => {
      this.items = [
        {
          label: 'Home',
          icon: 'pi pi-fw pi-home',
          routerLink: '/'
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
              label: 'Update Profile',
              icon: 'pi pi-fw pi-pencil',
              routerLink: `/dashboard/user/${user.data.id}/update`
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
    })
  }

  public save() {
    this.disabled = true;

    for (let key in this.quote) {
      if (this.quote[key] === '') {
        this.messageService.add({ severity: 'warn', summary: 'Warning', detail: `The field ${key} is required` });
        this.disabled = false;
        return;
      }
    }

    this.quoteService.createQuote(this.quote).subscribe({
      next: (quote: any) => {
        this.messageService.add({ severity: 'success', summary: 'Success', detail: 'Quote created with success' });

        this.quote = {
          author: '',
          quote: ''
        }

        this.disabled = false;
      },
      error: (error: any) => {
        this.messageService.add({ severity: 'error', summary: 'Error', detail: error.error.message });
        this.disabled = false;
      }
    });
  }
}
