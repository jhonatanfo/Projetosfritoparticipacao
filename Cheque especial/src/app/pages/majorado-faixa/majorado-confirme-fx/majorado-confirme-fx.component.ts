import { Component, OnInit } from "@angular/core";
import { Router } from "@angular/router";

@Component({
  selector: "app-majorado-confirme-fx",
  templateUrl: "./majorado-confirme-fx.component.html",
  styleUrls: ["./majorado-confirme-fx.component.scss"]
})
export class MajoradoConfirmeFxComponent implements OnInit {
  btnContinueText: string = "Confirmar";
  btnBackText: string = "Voltar";

  constructor(private router: Router) {}
  agree: boolean;

  ngOnInit() {}

  collapse(el): void {
    const parentClass = el.target.parentNode;
    const contDiv = parentClass.children[2];
    const arrow = parentClass.children[1];

    contDiv.classList.toggle("none");
    arrow.classList.toggle("rotate");
  }

  continuar(el) {
    if (el.target.innerHTML == "Confirmar" && this.agree == true) {
      this.router.navigate(["majorado-sucesso-fx"]);
    }
  }
  handleCheck() {
    this.agree = true;
  }
}
