import { Component, OnInit } from "@angular/core";
import { Router } from "@angular/router";

@Component({
  selector: "app-adesao-sucesso",
  templateUrl: "./adesao-sucesso.component.html",
  styleUrls: ["./adesao-sucesso.component.scss"]
})
export class AdesaoSucessoComponent implements OnInit {
  alertTypeSuccess: string = "success";
  txtAlertSuccess: string = "Cheque especial contratado";
  descAlertSuccess: string =
    "Agora você pode visualizar seu limite em Saldos e Extratos";
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
      this.router.navigate(["interna-adesao-seguro"]);
    }
  }
}
