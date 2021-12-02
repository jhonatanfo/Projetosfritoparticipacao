import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-sem-cadastrar',
  templateUrl: './sem-cadastrar.component.html',
  styleUrls: ['./sem-cadastrar.component.scss']
})
export class SemCadastrarComponent implements OnInit {

  constructor() { }

  appTitle: string;
  profilePic: string;
  avancar: number;
  modal: boolean;

  ngOnInit() {
    this.appTitle = 'PIX';
    this.profilePic = 'https://preview.fri.to/bradesco/profile.png';
    this.avancar = 0;
  }

  validaContinuar() {
    this.avancar == 0 ? this.avancar = 1 : this.avancar = 0;
  }

}
