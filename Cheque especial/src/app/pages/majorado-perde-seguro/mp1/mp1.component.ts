import { Component, OnInit } from "@angular/core";
import { Router } from "@angular/router";

@Component({
  selector: "app-mp1",
  templateUrl: "./mp1.component.html",
  styleUrls: ["./mp1.component.scss"]
})
export class Mp1Component implements OnInit {
  btnContinueText: string = "Aumentar";
  btnBackText: string = "Voltar";
  descAlertWarning: string =
    "Para este novo valor de limite, não há seguro proteção financeira dispoivel.";

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
    if (el.target.innerHTML == "Aumentar") {
      this.router.navigate(["confirme-majorado-perde-seguro"]);
    } else if (el.target.innerHTML == "Voltar") {
      this.router.navigate(["majorado-perde-s"]);
    }
  }
}
