import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';


@Component({
  selector: 'app-vincular-chave-email-celular',
  templateUrl: './vincular-chave-email-celular.component.html',
  styleUrls: ['./vincular-chave-email-celular.component.scss']
})
export class VincularChaveEmailCelularComponent implements OnInit {

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
      this.router.navigateByUrl('/cadastrando-email-celular-confirmacao');
    }, 300);
  }

}
