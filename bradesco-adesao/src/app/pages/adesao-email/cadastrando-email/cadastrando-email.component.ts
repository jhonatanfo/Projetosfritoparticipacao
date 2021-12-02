import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-cadastrando-email',
  templateUrl: './cadastrando-email.component.html',
  styleUrls: ['./cadastrando-email.component.scss']
})
export class CadastrandoEmailComponent implements OnInit {

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
