import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';

@Component({
  selector: 'app-vincular-chave',
  templateUrl: './vincular-chave.component.html',
  styleUrls: ['./vincular-chave.component.scss']
})
export class VincularChaveComponent implements OnInit {

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
      this.router.navigateByUrl('/cadastrando-celular-confirmacao');
    }, 300);
  }
}
