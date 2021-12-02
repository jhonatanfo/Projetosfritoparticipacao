import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';

@Component({
  selector: 'app-vincular-chave-cpf',
  templateUrl: './vincular-chave-cpf.component.html',
  styleUrls: ['./vincular-chave-cpf.component.scss']
})
export class VincularChaveCpfComponent implements OnInit {

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
      this.router.navigateByUrl('/confirmar-cpf');
    }, 300);
  }

}
