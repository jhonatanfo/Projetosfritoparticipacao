import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-sucesso-cadastro-cpf',
  templateUrl: './sucesso-cadastro-cpf.component.html',
  styleUrls: ['./sucesso-cadastro-cpf.component.scss']
})
export class SucessoCadastroCpfComponent implements OnInit {

  constructor() { }

  appTitle: string;
  profilePic: string;

  ngOnInit() {
    this.appTitle = 'PIX';
    this.profilePic = 'https://preview.fri.to/bradesco/profile.png'
  }


}
