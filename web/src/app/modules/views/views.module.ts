import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

/**
 * Modules
 */
import { SharedModule } from '../shared/shared.module';

/**
 * Components
 */
import { HomeComponent   } from '../../components/views/home/home.component';

@NgModule({
  declarations: [
    HomeComponent,
  ],
  exports: [
    HomeComponent,
  ],
  imports: [
    CommonModule,
    SharedModule
  ]
})
export class ViewsModule { }
