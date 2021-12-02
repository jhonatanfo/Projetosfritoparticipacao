import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-index-swipe',
  templateUrl: './index-swipe.component.html',
  styleUrls: ['./index-swipe.component.scss']
})
export class IndexSwipeComponent implements OnInit {

  constructor() { }

  appTitle: string;
  profilePic: string;

  ngOnInit() {
    this.appTitle = 'PIX';
    this.profilePic = 'https://preview.fri.to/bradesco/profile.png';
  }

  slides = [
    {
      img: "./assets/images/icon-pagamentos.svg",
      titulo: 'Pagamentos mais rápidos',
      texto: 'Por aqui, você faz e recebe pagamentos<br>em qualquer dia da semana.<br>E não importa o banco,<br>o dinheiro cai na hora!',
      continuar1: 'Continuar',
      pular: 'Pular'
    },

    {
      img: "./assets/images/icon-pagamentos.svg",
      titulo: 'Olha como é simples',
      texto: 'Seu número de celular, CPF e e-mail serão<br>chaves de identificação. Com a chave, você<br>faz transferências e recebe pagamentos,<br>é só enviá-la pra quem vai te pagar.',
      continuar2: 'Continuar',
    },
  ];

  slideConfig = {
    slidesToShow: 1,
    slidesToScroll: 1,
    arrows: false,
    dots: true,
  };

}
