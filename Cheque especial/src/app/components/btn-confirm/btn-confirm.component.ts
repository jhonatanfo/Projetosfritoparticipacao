import { Component, OnInit, Input } from '@angular/core';

@Component({
  selector: 'btn',
  templateUrl: './btn-confirm.component.html',
  styleUrls: ['./btn-confirm.component.scss']
})
export class BtnConfirmComponent implements OnInit {

  @Input() btnConfirmText: string;
  @Input() btnBackText: string;
  @Input() activeBack: boolean;
  @Input() btnClass: string;

  constructor() { }

  ngOnInit() {
  }

}
