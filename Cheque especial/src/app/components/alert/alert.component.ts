import { Component, OnInit, Input } from '@angular/core';

@Component({
  selector: 'alert',
  templateUrl: './alert.component.html',
  styleUrls: ['./alert.component.scss']
})
export class AlertComponent implements OnInit {

  @Input() type: string;
  @Input() txtAlert: string;
  @Input() txtDesc: string;

  constructor() { }

  ngOnInit() {
  }

}
