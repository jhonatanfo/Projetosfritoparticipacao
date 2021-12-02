import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-sem-cadastrar-dados-encerrar',
  templateUrl: './sem-cadastrar-dados-encerrar.component.html',
  styleUrls: ['./sem-cadastrar-dados-encerrar.component.scss']
})
export class SemCadastrarDadosEncerrarComponent implements OnInit {

  constructor() { }

  appTitle: string;
  profilePic: string;

  ngOnInit() {
    this.appTitle = 'PIX';
    this.profilePic = 'https://preview.fri.to/bradesco/profile.png';
  }

}
