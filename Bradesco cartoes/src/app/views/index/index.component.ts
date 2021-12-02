import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';

@Component({
  selector: 'app-index',
  templateUrl: './index.component.html',
  styleUrls: ['./index.component.scss']
})
export class IndexComponent implements OnInit {

  // NAVBAR
  appTitle: string;
  profilePic: string;
  // NAVBAR

  href = '';
  showView = true;

  constructor(private router: Router) { }

  ngOnInit() {
    this.appTitle = 'Bradesco';
    this.profilePic = 'https://preview.fri.to/bradesco/profile.png';
    this.href = this.router.url;

    console.log(this.href)
    if (this.href === '/?android=') {
      this.showView = false;
    } else {
      this.showView = true;
    }
  }

}
