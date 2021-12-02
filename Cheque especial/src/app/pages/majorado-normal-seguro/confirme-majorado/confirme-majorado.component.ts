import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';

@Component({
  selector: 'app-confirme-majorado',
  templateUrl: './confirme-majorado.component.html',
  styleUrls: ['./confirme-majorado.component.scss']
})

export class ConfirmeMajoradoComponent implements OnInit {
  constructor(private router: Router) { }
  agree: boolean;

  ngOnInit() { }

  handleCheck() {
    this.agree = true;
  }

  handleNext() {
    this.agree === true ? this.router.navigate(['sucesso-majorado']) : '';
  }
}
