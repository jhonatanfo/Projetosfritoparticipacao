import { Component, OnInit, Input } from '@angular/core';

@Component({
  selector: 'app-btn',
  templateUrl: './btn.component.html',
  styleUrls: ['./btn.component.scss']
})
export class BtnComponent implements OnInit {

  @Input() label: string;
  @Input() secondLabel: string;
  @Input() disabled: number;
  @Input() nextPage: string;
  @Input() lastPage: string;
  @Input() class: string;
  @Input() btnType: boolean;

  constructor() { }

  ngOnInit() {
  }

}