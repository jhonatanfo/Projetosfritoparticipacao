import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-cadastrando-codigo-e-email-celular',
  templateUrl: './cadastrando-codigo-e-email-celular.component.html',
  styleUrls: ['./cadastrando-codigo-e-email-celular.component.scss']
})
export class CadastrandoCodigoEEmailCelularComponent implements OnInit {

  constructor() { }

  appTitle: string;
  profilePic: string;
  modal: boolean;

  ngOnInit() {
    this.appTitle = 'PIX';
    this.profilePic = 'https://preview.fri.to/bradesco/profile.png';
    this.modal = false;
  }

}
