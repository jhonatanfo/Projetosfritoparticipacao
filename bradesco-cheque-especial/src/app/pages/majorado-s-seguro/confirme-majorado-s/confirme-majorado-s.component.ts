import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';

@Component({
  selector: 'app-confirme-majorado-s',
  templateUrl: './confirme-majorado-s.component.html',
  styleUrls: ['./confirme-majorado-s.component.scss']
})

export class ConfirmeMajoradoSComponent implements OnInit {

  constructor(private router: Router) { }

  agree: boolean;

  ngOnInit() {
  }

  handleCheck() {
    this.agree = true;
  }

  handleNext() {
    this.agree === true ? this.router.navigate(['sucesso-majorado-s']) : '';
  }

}
