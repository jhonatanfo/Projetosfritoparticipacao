import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-buscar-email-celular',
  templateUrl: './buscar-email-celular.component.html',
  styleUrls: ['./buscar-email-celular.component.scss']
})
export class BuscarEmailCelularComponent implements OnInit {

  constructor() { }

  appTitle: string;
  profilePic: string;
  area: string;
  showFirstInput: boolean;

  term: string;
  

  ngOnInit() {
    this.appTitle = 'PIX';
    this.profilePic = 'https://preview.fri.to/bradesco/profile.png';
    this.showFirstInput = true;
  }

  deleteNum() {
    (document.getElementById('input1') as HTMLInputElement).value = '';
  }

  deletePais() {
    (document.getElementById('input2') as HTMLInputElement).value = '';
  }


}
