import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';

@Component({
  selector: 'app-index-majorado-s-seguro',
  templateUrl: './index-majorado-s-seguro.component.html',
  styleUrls: ['./index-majorado-s-seguro.component.scss']
})
export class IndexMajoradoSSeguroComponent implements OnInit {

  constructor(private router: Router) { }
  exibir = true;

  ngOnInit() {
  }

  clickVerify(el) {
    if (el.target.innerHTML === 'Quero saber mais') {
      this.router.navigate(['majorado-ss']);
    } else {
      if (this.exibir === false) {
        this.exibir = true;
        this.router.navigate(['interna-majorado-s-seguro']);
      } else {
        this.exibir = false;
      }
    }
  }

}
