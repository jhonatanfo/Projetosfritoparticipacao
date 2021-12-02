import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';

@Component({
  selector: 'app-adesao-seguro1',
  templateUrl: './adesao-seguro1.component.html',
  styleUrls: ['./adesao-seguro1.component.scss']
})
export class AdesaoSeguro1Component implements OnInit {

  btnContinueText: string = 'Contratar';
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
    if (el.target.innerHTML == 'Contratar') {
      this.router.navigate(['confirme-seguro']);
    } else if (el.target.innerHTML == 'Voltar') {
      this.router.navigate(['adesao-s']);
    }
  }

}
