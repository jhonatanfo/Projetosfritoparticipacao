import { Component, OnInit } from "@angular/core";
import { Router } from "@angular/router";
@Component({
  selector: "app-confirme-adesao-s-seguro",
  templateUrl: "./confirme-adesao-s-seguro.component.html",
  styleUrls: ["./confirme-adesao-s-seguro.component.scss"]
})
export class ConfirmeAdesaoSSeguroComponent implements OnInit {
  constructor(private router: Router) {}
  agree: boolean;

  ngOnInit() {}

  handleCheck() {
    this.agree = true;
  }
  handleNext() {
    this.agree == true ? this.router.navigate(["sucesso-s-seguro"]) : "";
  }
}
