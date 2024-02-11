import { Component, OnInit } from '@angular/core';
import { MenuItem } from 'primeng/api';
import { UserService } from '../../../services/user.service';
import { JwtService } from '../../../services/jwt.service';

@Component({
  selector: 'app-home',
  templateUrl: './home.component.html',
  styleUrl: './home.component.css'
})
export class HomeComponent implements OnInit {
  public items: MenuItem[] = []

  constructor(private userService: UserService, private jwtService: JwtService) { }

  ngOnInit() {
    this.userService.getUser().subscribe({
      next: ({ data }: any ) => {
        this.items = [...this.items, {
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
              routerLink: `/dashboard/user/${data.id}/update`
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
        }]
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

}
