import { Component, Input, AfterViewInit } from '@angular/core';

@Component({
  selector: 'app-card-long',
  templateUrl: './card-long.component.html',
  styleUrls: ['./card-long.component.scss']
})
export class CardLongComponent implements AfterViewInit {

  @Input() cardId;
  @Input() svgLogo;
  @Input() cardTitle;
  @Input() cardText;
  @Input() bgCard;

  constructor() { }

  ngAfterViewInit() {
    const cardBg: HTMLElement = document.getElementById(this.cardId).children[0] as HTMLElement;
    cardBg.style.backgroundImage = this.bgCard;
  }

}
