import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-dados-encerrar',
  templateUrl: './dados-encerrar.component.html',
  styleUrls: ['./dados-encerrar.component.scss']
})
export class DadosEncerrarComponent implements OnInit {

  constructor() { }

  appTitle: string;
  profilePic: string;

  ngOnInit() {
    this.appTitle = 'PIX';
    this.profilePic = 'https://preview.fri.to/bradesco/profile.png';
  }

}
