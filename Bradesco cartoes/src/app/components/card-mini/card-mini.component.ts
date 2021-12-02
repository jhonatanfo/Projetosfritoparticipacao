import { Component, OnInit, Input } from '@angular/core';

@Component({
  selector: 'app-card-mini',
  templateUrl: './card-mini.component.html',
  styleUrls: ['./card-mini.component.scss']
})
export class CardMiniComponent implements OnInit {

  @Input() svgIcon;
  @Input() btnTitle;
  @Input() hasLink;

  constructor() { }

  ngOnInit() {
  }

}
