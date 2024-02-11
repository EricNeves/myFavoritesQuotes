import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { HttpClientModule } from '@angular/common/http';

/**
 * Modules
 */
import { SharedModule   } from '../shared/shared.module';
import { PanelModule    } from 'primeng/panel'
import { ButtonModule   } from 'primeng/button'
import { AvatarModule   } from 'primeng/avatar'
import { MenuModule     } from 'primeng/menu'
import { SkeletonModule } from 'primeng/skeleton'
import { InputTextModule } from 'primeng/inputtext';
import { PasswordModule } from 'primeng/password';
import { ToastModule } from 'primeng/toast'
import { InputTextareaModule } from 'primeng/inputtextarea';
import { FieldsetModule } from 'primeng/fieldset';
import { ConfirmDialogModule } from 'primeng/confirmdialog';


/**
 * Components
 */
import { HomeComponent        } from '../../components/views/home/home.component';
import { RandomQuoteComponent } from '../../components/views/random-quote/random-quote.component';
import { SignupComponent      } from '../../components/views/signup/signup.component';
import { LoginComponent       } from '../../components/views/login/login.component';
import { DashboardComponent   } from '../../components/views/dashboard/dashboard.component';
import { CreateComponent      } from '../../components/views/dashboard/create/create.component';
import { UpdateComponent      } from '../../components/views/dashboard/update/update.component';

@NgModule({
  declarations: [
    HomeComponent,
    RandomQuoteComponent,
    SignupComponent,
    LoginComponent,
    DashboardComponent,
    CreateComponent,
    UpdateComponent
  ],
  exports: [
    HomeComponent,
    RandomQuoteComponent,
    SignupComponent,
    LoginComponent,
    DashboardComponent,
    CreateComponent,
    UpdateComponent
  ],
  imports: [
    CommonModule,
    SharedModule,
    PanelModule,
    ButtonModule,
    AvatarModule,
    MenuModule,
    SkeletonModule,
    InputTextModule,
    PasswordModule,
    FormsModule,
    HttpClientModule,
    ToastModule,
    InputTextareaModule,
    FieldsetModule,
    ConfirmDialogModule
  ]
})
export class ViewsModule { }
