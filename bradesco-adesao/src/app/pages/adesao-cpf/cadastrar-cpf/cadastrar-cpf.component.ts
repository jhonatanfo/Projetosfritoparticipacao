import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-cadastrar-cpf',
  templateUrl: './cadastrar-cpf.component.html',
  styleUrls: ['./cadastrar-cpf.component.scss']
})
export class CadastrarCpfComponent implements OnInit {

  constructor() { }

  appTitle: string;
  profilePic: string;
  avancar: number;

  ngOnInit() {
    this.appTitle = 'PIX';
    this.profilePic = 'https://preview.fri.to/bradesco/profile.png';
    this.avancar = 0;
  }

  validaContinuar() {
    this.avancar == 0 ? this.avancar = 1 : this.avancar = 0;
  }

}
