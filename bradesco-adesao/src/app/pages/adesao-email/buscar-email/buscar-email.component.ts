import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-buscar-email',
  templateUrl: './buscar-email.component.html',
  styleUrls: ['./buscar-email.component.scss']
})
export class BuscarEmailComponent implements OnInit {

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
