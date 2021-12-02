import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-episodios',
  templateUrl: './episodios.component.html',
  styleUrls: ['./episodios.component.scss']
})
export class EpisodiosComponent implements OnInit {

  activeTab = 'search';
  sortArr = [];

  constructor() { }

  ngOnInit() {
    this.sortArr = this.episodioslides.slice();

    this.sortArr.sort(function (a, b) {
      return a.titulo.localeCompare(b.titulo);
    });
  }

  actualTab(activeTab) {
    this.activeTab = activeTab;
  }

  //https://www.npmjs.com/package/ngx-slick-carousel
  //https://stackoverflow.com/questions/58339362/asnavfor-not-working-ngx-slick-carousel-in-angular-8

  episodioslides = [
    {
      img: "../assets/images/fioti_juh.png",
      titulo: "Bravoz - Ep. 01 - Fióti <br> e Juh Almeida",
      ep: "01",
      videoURL: 'https://youtu.be/VjIzLoCmlg4',
      texto: "Em nosso 1º encontro, o cantor e empresário Fióti e a cineasta Juh Almeida apresentam sua voz ao descrever suas trajetórias, inspirações e como a arte como negócio valida o lado artístico.",
    },
    {
      img: "../assets/images/tuyo_carol.png",
      titulo: "Bravoz - Ep. 01 - Fióti e Juh Almeida",
      ep: "02",
      videoURL: 'https://youtu.be/x2nyr4bJqxY',
      texto: "Em nosso 1º encontro, o cantor e empresário Fióti e a cineasta Juh Almeida apresentam sua voz ao descrever suas trajetórias, inspirações e como a arte como negócio valida o lado artístico.",
    },
    {
      img: "../assets/images/fioti_juh.png",
      titulo: "Bravoz - Ep. 01 - Fióti e Juh Almeida",
      ep: "03",
      videoURL: 'https://youtu.be/-Uee9w9y4LI',
      texto: "Em nosso 1º encontro, o cantor e empresário Fióti e a cineasta Juh Almeida apresentam sua voz ao descrever suas trajetórias, inspirações e como a arte como negócio valida o lado artístico.",
    },
    {
      img: "../assets/images/tuyo_carol.png",
      titulo: "Bravoz - Ep. 01 - Fióti e Juh Almeida",
      ep: "04",
      videoURL: 'https://youtu.be/bLbToCVawE4',
      texto: "Em nosso 1º encontro, o cantor e empresário Fióti e a cineasta Juh Almeida apresentam sua voz ao descrever suas trajetórias, inspirações e como a arte como negócio valida o lado artístico.",
    }
  ];

  sliderConfig = {
    slidesToShow: 1,
    slidesToScroll: 1,
    dots: false,
    variableWidth: true,
    focusOnSelect: true,
    infinite: false
  };

}
