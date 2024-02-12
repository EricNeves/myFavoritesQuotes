import { Component, OnInit } from '@angular/core';
import { MenuItem, MessageService } from 'primeng/api';
import { JwtService } from '../../../../../services/jwt.service';
import { UserService } from '../../../../../services/user.service';
import { User } from '../../../../../models/user.model';

@Component({
  selector: 'app-update',
  templateUrl: './update.component.html',
  styleUrl: './update.component.css',
  providers: [MessageService]
})
export class UpdateComponent implements OnInit {
  public items: MenuItem[] = []
  public user: User<any> = {
    username: '',
    password: ''
  }

  public disabled: boolean = false;

  constructor(
    private messageService: MessageService, private userService: UserService,
    private jwtService: JwtService
  ) { }

  ngOnInit() {
    this.userService.getUser().subscribe((user: any) => {
      this.user = {
        id: user.data.id,
        username: user.data.username,
        password: ''
      }

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

  public update() {
    this.disabled = true;

    for (const key in this.user) {
      if (this.user[key] === '') {
        this.messageService.add({ severity: 'warn', summary: 'Warning', detail: `The field ${key} is required` });

        this.disabled = false;

        return;
      }
    }

    this.userService.updateUser(this.user).subscribe({
      next: (user: any) => {
        this.messageService.add({ severity: 'success', summary: 'Success', detail: user.message });

        this.disabled = false;
      },
      error: (error: any) => {
        this.messageService.add({ severity: 'error', summary: 'Error', detail: error.error.message });

        this.disabled = false;
      }
    })
  }
}
