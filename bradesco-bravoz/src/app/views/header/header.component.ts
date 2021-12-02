import { Component, OnInit } from '@angular/core';
import { HostListener } from '@angular/core';

@Component({
  selector: 'app-header',
  templateUrl: './header.component.html',
  styleUrls: ['./header.component.scss']
})

export class HeaderComponent implements OnInit {

  constructor() { }
  isCollapsed: any;

  @HostListener('window:scroll') onWindowScroll() {
    const element = document.querySelector('.navbar');
    if (window.pageYOffset > element.clientHeight) {
      element.classList.add('nav-scrolled');
    } else {
      element.classList.remove('nav-scrolled');
    }
  }

  ngOnInit() { }

  scrollToElement(element): void {
    let el = document.getElementById(element);
    el.scrollIntoView({ behavior: "smooth", block: "start", inline: "nearest" });
  }
}
