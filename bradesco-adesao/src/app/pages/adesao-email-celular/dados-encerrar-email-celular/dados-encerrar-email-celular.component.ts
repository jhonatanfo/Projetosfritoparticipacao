import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-dados-encerrar-email-celular',
  templateUrl: './dados-encerrar-email-celular.component.html',
  styleUrls: ['./dados-encerrar-email-celular.component.scss']
})
export class DadosEncerrarEmailCelularComponent implements OnInit {

  constructor() { }

  appTitle: string;
  profilePic: string;

  ngOnInit() {
    this.appTitle = 'PIX';
    this.profilePic = 'https://preview.fri.to/bradesco/profile.png';
  }

}
