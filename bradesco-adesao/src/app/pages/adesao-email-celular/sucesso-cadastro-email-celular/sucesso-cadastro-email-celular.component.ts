import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-sucesso-cadastro-email-celular',
  templateUrl: './sucesso-cadastro-email-celular.component.html',
  styleUrls: ['./sucesso-cadastro-email-celular.component.scss']
})
export class SucessoCadastroEmailCelularComponent implements OnInit {

  constructor() { }

  appTitle: string;
  profilePic: string;

  ngOnInit() {
    this.appTitle = 'PIX';
    this.profilePic = 'https://preview.fri.to/bradesco/profile.png'
  }

}
