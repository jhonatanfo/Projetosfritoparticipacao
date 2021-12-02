import { Component, OnInit } from "@angular/core";
import { Router } from "@angular/router";

@Component({
  selector: "app-index",
  templateUrl: "./index-adesao-seguro.component.html",
  styleUrls: ["./index-adesao-seguro.component.scss"]
})
export class IndexAdesaoSeguro implements OnInit {
  exibir: boolean = true;

  constructor(private router: Router) {}

  ngOnInit() {}

  clickVerify(el) {
    if (el.target.innerHTML == "Quero saber mais") {
      this.router.navigate(["adesao-sem-seguro"]);
    } else {
      if (this.exibir == false) {
        this.exibir = true;
        this.router.navigate(["interna-adesao-seguro"]);
      } else {
        this.exibir = false;
      }
    }
  }
}
