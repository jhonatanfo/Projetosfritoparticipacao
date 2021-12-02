import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-cadastrando-celular',
  templateUrl: './cadastrando-celular.component.html',
  styleUrls: ['./cadastrando-celular.component.scss']
})
export class CadastrandoCelularComponent implements OnInit {

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
