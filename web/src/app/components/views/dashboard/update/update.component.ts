import { Component, OnInit } from '@angular/core';
import { MenuItem, MessageService } from 'primeng/api';
import { Quote } from '../../../../models/quote.model';
import { QuoteService } from '../../../../services/quote.service';
import { Router, ActivatedRoute } from '@angular/router';
import { JwtService } from '../../../../services/jwt.service';

@Component({
  selector: 'app-update',
  templateUrl: './update.component.html',
  styleUrl: './update.component.css',
  providers: [MessageService]
})
export class UpdateComponent implements OnInit {
  public items: MenuItem[] = []
  public quote: Quote<any> = {
    id: '',
    author: '',
    quote: ''
  };

  public disabled: boolean = false;

  constructor(
    private router: Router, private messageService: MessageService,
    private jwtService: JwtService, private quoteService: QuoteService, private route: ActivatedRoute
  ) { }

  ngOnInit() {

    this.quoteService.getQuoteById(this.route.snapshot.params['id']).subscribe({
      next: (response: any) => {
        this.quote = {
          id: response.data.id,
          author: response.data.author,
          quote: response.data.quote
        }
      },
      error: (error) => {
        this.router.navigate(['/dashboard'])
      }
    })

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

  public update() {
    this.disabled = true

    for (let key in this.quote) {
      if (this.quote[key] === '') {
        this.messageService.add({ severity: 'warn', summary: 'Warning', detail: `The field ${key} is required` });
        this.disabled = false;
        return;
      }
    }

    this.quoteService.updateQuote(this.quote.id, this.quote).subscribe({
      next: (response: any) => {
        this.messageService.add({ severity: 'success', summary: 'Success', detail: response.message });
        this.disabled = false;
      },
      error: (error) => {
        this.messageService.add({ severity: 'error', summary: 'Error', detail: error.error.message });
        this.disabled = false;
      }
    })
  }
}
