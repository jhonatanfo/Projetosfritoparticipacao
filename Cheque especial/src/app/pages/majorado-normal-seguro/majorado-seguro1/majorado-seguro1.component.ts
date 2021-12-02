import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';

@Component({
  selector: 'app-majorado-seguro1',
  templateUrl: './majorado-seguro1.component.html',
  styleUrls: ['./majorado-seguro1.component.scss']
})
export class MajoradoSeguro1Component implements OnInit {

  btnContinueText = 'Aumentar';
  btnBackText = 'Voltar';

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
    if (el.target.innerHTML === 'Aumentar') {
      this.router.navigate(['confirme-majorado']);
    } else if (el.target.innerHTML === 'Voltar') {
      this.router.navigate(['majorado-s']);
    }
  }

}
