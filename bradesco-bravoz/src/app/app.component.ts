import { Component } from '@angular/core';
import smoothscroll from 'smoothscroll-polyfill';

@Component({
  selector: 'app-root',
  template: '<router-outlet></router-outlet>',
  styleUrls: []
})
export class AppComponent {
  constructor() {
    smoothscroll.polyfill();
  }
}
