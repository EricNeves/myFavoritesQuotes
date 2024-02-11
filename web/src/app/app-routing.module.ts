import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';

import { HomeComponent } from './components/views/home/home.component';
import { SignupComponent } from './components/views/signup/signup.component';
import { LoginComponent } from './components/views/login/login.component';
import { DashboardComponent } from './components/views/dashboard/dashboard.component';

import { authGuard } from './auth.guard';

const routes: Routes = [
  { path: '',       component: HomeComponent },
  { path: 'signup', component: SignupComponent },
  { path: 'login',  component: LoginComponent },
  { path: 'dashboard', component: DashboardComponent, canActivate: [authGuard]}
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
