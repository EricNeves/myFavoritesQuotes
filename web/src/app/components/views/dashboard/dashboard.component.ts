import { Component, OnInit } from '@angular/core';

import { UserService } from '../../../services/user.service';

import { User } from '../../../models/user.model';

@Component({
  selector: 'app-dashboard',
  templateUrl: './dashboard.component.html',
  styleUrl: './dashboard.component.css'
})
export class DashboardComponent implements OnInit {
  public user: User<any> = {};

  constructor(private userService: UserService) { }

  ngOnInit() {
    this.userService.getUser().subscribe((user: User<any>) => {
      this.user = user;
    });
  }
}
