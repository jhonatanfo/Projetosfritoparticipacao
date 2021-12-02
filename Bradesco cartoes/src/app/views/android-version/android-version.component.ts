import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-android-version',
  templateUrl: './android-version.component.html',
  styleUrls: ['./android-version.component.scss']
})
export class AndroidVersionComponent implements OnInit {

  // cardLong 1 variables
  bgCardLong1 = 'linear-gradient(to right, #9868bc, #73308b)';
  svgCardLong1 = 'assets/svg/cartao1.svg';
  titleCardLong1 = 'Solicite um novo cartão';
  textCardLong1 = 'Peça agora!';
  cardId = 'cardLong1';
  // cardLong 1 variables

  // Card mini only icon
  iconMini = 'assets/svg/google.svg';
  titleMini = '';
  // Card mini only icon

  cardsGroup1: Array<any> = [
    { icon: 'assets/svg/qr_code.svg', title: 'QR Code' },
    { icon: 'assets/svg/limite_cartao.svg', title: 'Limite <br> do cartão' },
    { icon: 'assets/svg/extrato_cartao.svg', title: 'Extrato <br> do cartão' },
    { icon: 'assets/svg/pag_fatura.svg', title: 'Pagamentos <br> da fatura' },
    { icon: 'assets/svg/aviso_viagem.svg', title: 'Aviso <br> de viagem' },
    { icon: 'assets/svg/desb_cartoes.svg', title: 'Desbloqueio <br> de cartões' },
    { icon: 'assets/svg/visu_senha.svg', title: 'Visualizar <br> senha' },
  ];

  // cardLong 2 variables
  bgCardLong2 = 'linear-gradient(to left, #f36178, #e1173f)';
  svgCardLong2 = 'assets/svg/cartao2.svg';
  titleCardLong2 = 'Cartão virtual';
  textCardLong2 = 'Compre online com segurança!';
  cardId2 = 'cardLong2';
  // cardLong 2 variables

  cardsGroup2: Array<any> = [
    { icon: 'assets/svg/fatura_digital.svg', title: 'Fatura <br> digital', hasLink: true },
    { icon: 'assets/svg/notificacoes.svg', title: 'Notificações', hasLink: true },
    { icon: 'assets/svg/permissoes.svg', title: 'Permissões', hasLink: true },
    { icon: 'assets/svg/cartao_adicional.svg', title: 'Cartão <br> adicional', hasLink: true },
    { icon: 'assets/svg/seguranca.svg', title: 'Segurança', hasLink: true },
    { icon: 'assets/svg/gerenciar.svg', title: 'Gerenciar <br> cartões', hasLink: true },
  ];

  constructor() { }

  ngOnInit() {
  }

}
