import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-cadastrando-celular-confirmacao',
  templateUrl: './cadastrando-celular-confirmacao.component.html',
  styleUrls: ['./cadastrando-celular-confirmacao.component.scss']
})
export class CadastrandoCelularConfirmacaoComponent implements OnInit {

  constructor() { }

  appTitle: string;
  profilePic: string;
  avancar: number;

  ngOnInit() {
    this.appTitle = 'PIX';
    this.profilePic = 'https://preview.fri.to/bradesco/profile.png';
    this.avancar = 0;

    console.log(this.avancar)
  }

  removeDisabled() {
    document.getElementById('telefone').removeAttribute('disabled');
    document.getElementById('telefone').focus();
  }

  validaContinuar() {
    this.avancar == 0 ? this.avancar = 1 : this.avancar = 0;
  }
}
