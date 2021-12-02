import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';

import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';

// NPM Packages
import { SlickCarouselModule } from 'ngx-slick-carousel';

// Views
import { IndexComponent } from './views/index/index.component';
import { HeaderComponent } from './views/header/header.component';
import { HomeComponent } from './views/home/home.component';
import { ArtistasComponent } from './views/artistas/artistas.component';
import { EpisodiosComponent } from './views/episodios/episodios.component';
import { ProjetoComponent } from './views/projeto/projeto.component';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';

import { CollapseModule } from 'ngx-bootstrap/collapse';
import { FooterComponent } from './views/footer/footer.component';

@NgModule({
  declarations: [
    AppComponent,
    IndexComponent,
    HeaderComponent,
    HomeComponent,
    FooterComponent,
    ArtistasComponent,
    EpisodiosComponent,
    ProjetoComponent,
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    CollapseModule.forRoot(),
    BrowserAnimationsModule,
    SlickCarouselModule
  ],
  providers: [],
  bootstrap: [AppComponent]
})
export class AppModule { }
