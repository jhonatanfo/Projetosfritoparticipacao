import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-cadastrado-sucesso',
  templateUrl: './cadastrado-sucesso.component.html',
  styleUrls: ['./cadastrado-sucesso.component.scss']
})
export class CadastradoSucessoComponent implements OnInit {

  constructor() { }

  appTitle: string;
  profilePic: string;

  ngOnInit() {
    this.appTitle = 'PIX';
    this.profilePic = 'https://preview.fri.to/bradesco/profile.png'
  }

}
