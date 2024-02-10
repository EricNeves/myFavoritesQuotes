import { Component, OnInit } from '@angular/core';
import { MenuItem } from 'primeng/api';

@Component({
  selector: 'app-signup',
  templateUrl: './signup.component.html',
  styleUrl: './signup.component.css'
})
export class SignupComponent implements OnInit {
  public items: MenuItem[] = []

  constructor() { }

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
}
