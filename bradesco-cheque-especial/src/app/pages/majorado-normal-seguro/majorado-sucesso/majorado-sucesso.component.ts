import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';

@Component({
  selector: 'app-majorado-sucesso',
  templateUrl: './majorado-sucesso.component.html',
  styleUrls: ['./majorado-sucesso.component.scss']
})
export class MajoradoSucessoComponent implements OnInit {
  alertTypeSuccess = 'success';
  txtAlertSuccess = 'Aumento de limite do cheque especial concluído';
  descAlertSuccess =
    'Você já pode consultar seu limite na opção Saldos e Extratos.';
  btnContinueText = 'Voltar para Saldos e Extratos';

  constructor(private router: Router) { }

  ngOnInit() { }

  collapse(el): void {
    const parentClass = el.target.parentNode;
    const contDiv = parentClass.children[2];
    const arrow = parentClass.children[1];

    contDiv.classList.toggle('none');
    arrow.classList.toggle('rotate');
  }

  continuar(el) {
    if (el.target.innerHTML === 'Voltar para Saldos e Extratos') {
      this.router.navigate(['interna-majorado-seguro']);
    }
  }
}
