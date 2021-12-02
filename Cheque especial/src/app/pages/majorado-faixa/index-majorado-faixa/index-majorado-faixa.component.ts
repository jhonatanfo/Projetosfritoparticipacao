import { Component, OnInit } from "@angular/core";
import { Router } from "@angular/router";

@Component({
  selector: "app-index-majorado-faixa",
  templateUrl: "./index-majorado-faixa.component.html",
  styleUrls: ["./index-majorado-faixa.component.scss"]
})
export class IndexMajoradoFaixaComponent implements OnInit {
  exibir: boolean = true;

  constructor(private router: Router) {}

  ngOnInit() {}

  clickVerify(el) {
    if (el.target.innerHTML == "Quero saber mais") {
      this.router.navigate(["majorado-faixa1"]);
    } else {
      if (this.exibir == false) {
        this.exibir = true;
        this.router.navigate(["interna-majorado-faixa"]);
      } else {
        this.exibir = false;
      }
    }
  }
}
