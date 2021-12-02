import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';

@Component({
  selector: 'app-majorado1',
  templateUrl: './majorado1.component.html',
  styleUrls: ['./majorado1.component.scss']
})
export class Majorado1Component implements OnInit {

  btnContinueText: string = 'Aumentar';
  btnBackText: string = 'Voltar';

  constructor(private router: Router) { }

  ngOnInit() {
  }

  collapse(el): void {
    const parentClass = el.target.parentNode;
    const contDiv = parentClass.children[2];
    const arrow = parentClass.children[1];

    contDiv.classList.toggle('none');
    arrow.classList.toggle('rotate')
  }

  continuar(el) {
    if (el.target.innerHTML == 'Aumentar') {
      this.router.navigate(['majorado-confirme-fx']);
    } else if (el.target.innerHTML == 'Voltar') {
      this.router.navigate(['majorado-faixa']);
    }
  }

}
