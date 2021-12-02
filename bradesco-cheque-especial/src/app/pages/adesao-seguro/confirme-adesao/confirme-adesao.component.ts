import { Component, OnInit } from "@angular/core";
import { Router } from "@angular/router";
@Component({
  selector: "app-confirme-adesao",
  templateUrl: "./confirme-adesao.component.html",
  styleUrls: ["./confirme-adesao.component.scss"]
})
export class ConfirmeAdesaoComponent implements OnInit {
  constructor(private router: Router) {}
  agree: boolean;

  ngOnInit() {}
  handleCheck() {
    this.agree = true;
  }
  handleNext() {
    this.agree == true ? this.router.navigate(["sucesso-seguro"]) : "";
  }
}
