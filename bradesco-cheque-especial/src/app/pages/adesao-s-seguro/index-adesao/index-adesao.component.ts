import { Component, OnInit } from "@angular/core";
import { Router } from "@angular/router";

@Component({
  selector: "app-index-adesao",
  templateUrl: "./index-adesao.component.html",
  styleUrls: ["./index-adesao.component.scss"]
})
export class IndexAdesaoComponent implements OnInit {
  exibir: boolean = true;

  constructor(private router: Router) {}

  ngOnInit() {}

  clickVerify(el) {
    if (el.target.innerHTML == "Quero saber mais") {
      this.router.navigate(["adesao-seguro"]);
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
