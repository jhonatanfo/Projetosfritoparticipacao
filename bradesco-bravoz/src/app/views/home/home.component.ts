import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-home',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.scss']
})
export class HomeComponent implements OnInit {

  constructor() { }

  ngOnInit() {
  }

  // https://www.npmjs.com/package/ngx-slick-carousel

  slides = [
    {
      imgOne: "./assets/images/slide-02-one.jpg",
      ep: '4',
      nameOne: 'Margareth Menezes',
      nameTwo: 'Tainara Cerqueira',
      txt: 'Preservação cultural e negócio',
      imgTwo: "./assets/images/slide-02-two.jpg",
      videoURL: 'https://youtu.be/bLbToCVawE4'
    },
    {
      imgOne: "./assets/images/slide-01-one.jpg",
      ep: '3',
      nameOne: 'Larissa Luz',
      nameTwo: 'Jean Lins',
      txt: 'Protagonismo nos negócios',
      imgTwo: "./assets/images/slide-01-two.jpg",
      videoURL: 'https://youtu.be/-Uee9w9y4LI'
    },
    {
      imgOne: "./assets/images/slide-02-one.jpg",
      ep: '2',
      nameOne: 'Tuyo',
      nameTwo: 'Caroline Lima',
      txt: 'Empreendedorismo aliado a arte',
      imgTwo: "./assets/images/slide-02-two.jpg",
      videoURL: 'https://youtu.be/x2nyr4bJqxY'
    },
    {
      imgOne: "./assets/images/slide-01-one.jpg",
      ep: '1',
      nameOne: 'Fióti',
      nameTwo: 'Juh Almeida',
      txt: 'Todo artista é um empreendedor',
      imgTwo: "./assets/images/slide-01-two.jpg",
      videoURL: 'https://youtu.be/VjIzLoCmlg4'
    },
  ];

  slideFor = {
    asNavFor: ".classSlideNav",
    slidesToShow: 1,
    slidesToScroll: 1,
    arrows: false,
    fade: true,
    focusOnSelect: false,
    infinite: false,
  };

  slideNav = {
    asNavFor: ".classSlideFor",
    dots: false,
    infinite: false,
    speed: 300,
    arrows: true,
    slidesToShow: 1,
    variableWidth: true,
    focusOnSelect: true,
    prevArrow: '.slide-principal .icon-left',
    nextArrow: '.slide-principal .icon-right',
  };

}
