import { Component, OnInit } from '@angular/core';
import { MenuItem } from 'primeng/api';
import { Router } from '@angular/router';
import { MessageService } from 'primeng/api';

import { UserService } from '../../../services/user.service';
import { User } from '../../../models/user.model';
import { JwtService } from '../../../services/jwt.service';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrl: './login.component.css',
  providers: [MessageService]
})
export class LoginComponent implements OnInit {
  public items: MenuItem[] = []
  public disabled: boolean = false;

  public user: User<string> = {
    email: '',
    password: ''
  }

  constructor(
    private userService: UserService, private router: Router, private messageService: MessageService,
    private jwtService: JwtService
  ) { }

  ngOnInit() {
    this.userService.getUser().subscribe({
      next: ({ data }: any ) => {
        this.router.navigate(['/dashboard']);
      }
    })

    this.items = [
      {
        label: 'Home',
        icon: 'pi pi-fw pi-home',
        routerLink: '/'
      },
      {
        label: 'Join',
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

  public auth() {
    this.disabled = true;

    for (const key in this.user) {
      if (this.user[key] === '') {
        this.messageService.add({severity: 'warn', summary: 'Warning', detail: `The field ${key} is required`});

        this.disabled = false;

        return;
      }
    }

    this.userService.login(this.user).subscribe({
      next: (response: any) => {
        this.jwtService.setToken(response.jwt);

        this.router.navigate(['/dashboard']);
      },
      error: (error: any) => {
        this.messageService.add({severity: 'error', summary: 'Error', detail: error.error.message});

        this.disabled = false;

        return;
      }
    })
  }
}
