import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';

@Component({
  selector: 'app-confirmar',
  templateUrl: './confirmar.component.html',
  styleUrls: ['./confirmar.component.scss']
})
export class ConfirmarComponent implements OnInit {

  constructor(private router: Router) { }

  appTitle: string;
  profilePic: string;
  routeValidation: number;

  exibeIcone: boolean;
  exibeBotao: boolean;

  ngOnInit() {
    this.appTitle = 'PIX';
    this.profilePic = 'https://preview.fri.to/bradesco/profile.png';
    this.routeValidation = 1;
    this.exibeIcone = false;
    this.exibeBotao = true;
  }

  nextPage() {
    console.log('Pode avançar');

    setTimeout(() => {
      this.exibeIcone = true;
      this.exibeBotao = false;

      setTimeout(() => {
        this.router.navigateByUrl('/sucesso-cadastro');
      }, 300);
    }, 300);
  }

  validationCheck() {
    this.routeValidation === 1 ? this.routeValidation = 0 : this.routeValidation = 1;
  }

}
