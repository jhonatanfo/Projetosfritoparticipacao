import { Component, OnInit } from "@angular/core";
import { Router } from "@angular/router";

@Component({
  selector: "app-index-mp",
  templateUrl: "./index-mp.component.html",
  styleUrls: ["./index-mp.component.scss"]
})
export class IndexMpComponent implements OnInit {
  exibir: boolean = true;

  constructor(private router: Router) {}

  ngOnInit() {}

  clickVerify(el) {
    if (el.target.innerHTML == "Quero saber mais") {
      this.router.navigate(["majorado-perde-seguro"]);
    } else {
      if (this.exibir == false) {
        this.exibir = true;
        this.router.navigate(["interna-majorado-perde-seguro"]);
      } else {
        this.exibir = false;
      }
    }
  }
}
