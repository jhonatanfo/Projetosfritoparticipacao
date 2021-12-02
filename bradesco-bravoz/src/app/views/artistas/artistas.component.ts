import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-artistas',
  templateUrl: './artistas.component.html',
  styleUrls: ['./artistas.component.scss']
})
export class ArtistasComponent implements OnInit {

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
      img: "../assets/images/artista-01.png",
      titulo: "Fióti",
      ep: "ep.1",
      texto: "Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam",
    },
    {
      img: "../assets/images/artista-02.png",
      titulo: "Juh Almeida",
      ep: "ep.1",
      texto: "Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam",
    },
    {
      img: "../assets/images/artista-01.png",
      titulo: "Caroline Lima",
      ep: "ep.2",
      texto: "Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam",
    },
    {
      img: "../assets/images/artista-02.png",
      titulo: "Tuyo",
      ep: "ep.2",
      texto: "Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam",
    }
  ];

  sliderConfig = {
    slidesToShow: 1,
    slidesToScroll: 1,
    dots: false,
    variableWidth: true,
    focusOnSelect: true,
    infinite: false,
    prevArrow: '.right .icon-left',
    nextArrow: '.right .icon-right',
  };

}