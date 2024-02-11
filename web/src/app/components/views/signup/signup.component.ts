import { Component, OnInit } from '@angular/core';
import { MenuItem } from 'primeng/api';
import { MessageService } from 'primeng/api';

import { UserService } from '../../../services/user.service';

import { User } from '../../../models/user.model';

@Component({
  selector: 'app-signup',
  templateUrl: './signup.component.html',
  styleUrl: './signup.component.css',
  providers: [MessageService]
})
export class SignupComponent implements OnInit {
  public items: MenuItem[] = []
  public disabled: boolean = false;

  public user: User<string> = {
    username: '',
    email: '',
    password: ''
  }

  constructor(private userService: UserService, private messageService: MessageService) { }

  ngOnInit() {
    this.items = [
      {
        label: 'Home',
        icon: 'pi pi-fw pi-home',
        routerLink: '/'
      },
      {
        label: 'Create Quote',
        icon: 'pi pi-fw pi-plus',
        items: [
          {
            label: 'Sign Up',
            icon: 'pi pi-fw pi-user-plus',
            routerLink: '/signup'
          },
          {
            label: 'Login',
            icon: 'pi pi-fw pi-sign-in',
            routerLink: '/login'
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
      }
    ]
  }

  public save(): void {
    this.disabled = true;

    for (const key in this.user) {
      if (this.user[key] === '') {
        this.messageService.add({ severity: 'warn', summary: 'Warning', detail: `The field ${key} is required` });

        this.disabled = false;

        return;
      }
    }

    this.userService.register(this.user).subscribe({
      next: (response: any) => {
        this.messageService.add({ severity: 'success', summary: 'Success', detail: response.message });
      },
      error: (error) => {
        this.messageService.add({ severity: 'error', summary: 'Error', detail: error.error.message });

        this.disabled = false;

        return;
      }
    })

    this.disabled = false;
  }
}
