import { Component, OnInit } from "@angular/core";
import { Router } from "@angular/router";

@Component({
  selector: "app-majorado-sucesso-fx",
  templateUrl: "./majorado-sucesso-fx.component.html",
  styleUrls: ["./majorado-sucesso-fx.component.scss"]
})
export class MajoradoSucessoFxComponent implements OnInit {
  alertTypeSuccess: string = "success";
  txtAlertSuccess: string = "Aumento de limite do cheque especial concluído";
  descAlertSuccess: string =
    "Você já pode consultar seu limite na opção Saldos e Extratos.";
  btnContinueText: string = "Voltar para Saldos e Extratos";

  constructor(private router: Router) {}

  ngOnInit() {}

  collapse(el): void {
    const parentClass = el.target.parentNode;
    const contDiv = parentClass.children[2];
    const arrow = parentClass.children[1];

    contDiv.classList.toggle("none");
    arrow.classList.toggle("rotate");
  }

  continuar(el) {
    if (el.target.innerHTML == "Voltar para Saldos e Extratos") {
      this.router.navigate(["interna-majorado-faixa"]);
    }
  }
}
