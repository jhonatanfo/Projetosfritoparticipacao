import { Component, OnInit } from "@angular/core";
import { Router } from "@angular/router";
@Component({
  selector: "app-mp-confirme",
  templateUrl: "./mp-confirme.component.html",
  styleUrls: ["./mp-confirme.component.scss"]
})
export class MpConfirmeComponent implements OnInit {
  constructor(private router: Router) {}
  agree: boolean;

  ngOnInit() {}

  handleCheck() {
    this.agree = true;
  }
  handleNext() {
    this.agree == true
      ? this.router.navigate(["majorado-perde-seguro-sucesso"])
      : "";
  }
}
