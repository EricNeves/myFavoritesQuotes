import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

/**
 * Modules
 */
import { SharedModule   } from '../shared/shared.module';
import { PanelModule    } from 'primeng/panel'
import { ButtonModule   } from 'primeng/button'
import { AvatarModule   } from 'primeng/avatar'
import { MenuModule     } from 'primeng/menu'
import { SkeletonModule } from 'primeng/skeleton'

/**
 * Components
 */
import { HomeComponent        } from '../../components/views/home/home.component';
import { RandomQuoteComponent } from '../../components/views/random-quote/random-quote.component';

@NgModule({
  declarations: [
    HomeComponent,
    RandomQuoteComponent
  ],
  exports: [
    HomeComponent,
    RandomQuoteComponent
  ],
  imports: [
    CommonModule,
    SharedModule,
    PanelModule,
    ButtonModule,
    AvatarModule,
    MenuModule,
    SkeletonModule
  ]
})
export class ViewsModule { }
