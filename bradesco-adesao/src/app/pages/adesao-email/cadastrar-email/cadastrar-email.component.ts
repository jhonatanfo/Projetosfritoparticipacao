import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-cadastrar-email',
  templateUrl: './cadastrar-email.component.html',
  styleUrls: ['./cadastrar-email.component.scss']
})
export class CadastrarEmailComponent implements OnInit {

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
