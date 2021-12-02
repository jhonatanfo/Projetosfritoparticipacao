import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';

@Component({
  selector: 'app-vincular-chave-email',
  templateUrl: './vincular-chave-email.component.html',
  styleUrls: ['./vincular-chave-email.component.scss']
})
export class VincularChaveEmailComponent implements OnInit {

  constructor(private router: Router) { }

  appTitle: string;
  profilePic: string;

  ngOnInit() {
    this.appTitle = 'PIX';
    this.profilePic = 'https://preview.fri.to/bradesco/profile.png';
  }

  btnActive(el: any): void {
    const btnsChildrens = document.querySelectorAll('.btn');

    btnsChildrens.forEach(element => {
      element.classList.remove('active');
    });

    el.target.classList.add('active');

    setTimeout(() => {
      this.router.navigateByUrl('/cadastrando-email-confirmacao');
    }, 300);
  }

}
