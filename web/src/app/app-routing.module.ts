import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';

import { HomeComponent                 } from './components/views/home/home.component';
import { SignupComponent               } from './components/views/signup/signup.component';
import { LoginComponent                } from './components/views/login/login.component';
import { DashboardComponent            } from './components/views/dashboard/dashboard.component';
import { CreateComponent               } from './components/views/dashboard/create/create.component';
import { UpdateComponent               } from './components/views/dashboard/update/update.component';
import { UpdateComponent as UserUpdate } from './components/views/dashboard/user/update/update.component'

import { authGuard } from './auth.guard';

const routes: Routes = [
  { path: '',                           component: HomeComponent },
  { path: 'signup',                     component: SignupComponent },
  { path: 'login',                      component: LoginComponent },
  { path: 'dashboard',                  component: DashboardComponent, canActivate: [authGuard]},
  { path: 'dashboard/quote/create',     component: CreateComponent,    canActivate: [authGuard]},
  { path: 'dashboard/quote/:id/update', component: UpdateComponent,    canActivate: [authGuard]},
  { path: 'dashboard/user/:id/update',  component: UserUpdate,         canActivate: [authGuard]}
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
