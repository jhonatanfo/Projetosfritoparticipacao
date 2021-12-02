import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';

@Component({
  selector: 'app-index-majorado-seguro',
  templateUrl: './index-majorado-seguro.component.html',
  styleUrls: ['./index-majorado-seguro.component.scss']
})
export class IndexMajoradoSeguroComponent implements OnInit {
  exibir = true;

  constructor(private router: Router) { }

  ngOnInit() { }

  clickVerify(el) {
    if (el.target.innerHTML === 'Quero saber mais') {
      this.router.navigate(['majorado-seguro']);
    } else {
      if (this.exibir === false) {
        this.exibir = true;
        this.router.navigate(['interna-majorado-seguro']);
      } else {
        this.exibir = false;
      }
    }
  }
}
