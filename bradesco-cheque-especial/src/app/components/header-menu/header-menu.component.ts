import { Component, OnInit, Input } from '@angular/core';

@Component({
  selector: 'header-menu',
  templateUrl: './header-menu.component.html',
  styleUrls: ['./header-menu.component.scss']
})
export class HeaderMenuComponent implements OnInit {

  @Input() titleHeader;
  @Input() profImg;

  constructor() { }

  ngOnInit() {
  }

}
