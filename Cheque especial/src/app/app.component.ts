import { Component } from '@angular/core';
import { Router } from '@angular/router';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.scss']
})

export class AppComponent {

  titleApp: string = '';
  profilePic: string = 'https://preview.fri.to/bradesco/profile.png';

  constructor(private router: Router) { }

  ngDoCheck(): void {
    if (this.router.url == '/') {
      this.titleApp = 'Saldo e extrato'
    } else {
      this.titleApp = 'Cheque especial'
    }
  }
}


