import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';

import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { IndexComponent } from './views/index/index.component';
import { CardMiniComponent } from './components/card-mini/card-mini.component';
import { IosVersionComponent } from './views/ios-version/ios-version.component';
import { HeaderComponent } from './components/header/header.component';
import { CardLongComponent } from './components/card-long/card-long.component';
import { AndroidVersionComponent } from './views/android-version/android-version.component';

@NgModule({
  declarations: [
    AppComponent,
    IndexComponent,
    CardMiniComponent,
    IosVersionComponent,
    HeaderComponent,
    CardLongComponent,
    AndroidVersionComponent
  ],
  imports: [
    BrowserModule,
    AppRoutingModule
  ],
  providers: [],
  bootstrap: [AppComponent]
})
export class AppModule { }
