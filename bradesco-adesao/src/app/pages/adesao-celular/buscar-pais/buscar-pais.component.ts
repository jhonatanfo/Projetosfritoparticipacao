import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-buscar-pais',
  templateUrl: './buscar-pais.component.html',
  styleUrls: ['./buscar-pais.component.scss']
})
export class BuscarPaisComponent implements OnInit {

  constructor() { }

  appTitle: string;
  profilePic: string;
  area: string;
  showFirstInput: boolean;

  term: string;
  filterData = [
    {
      Name: 'Afeganistão (+93)',
    },
    {
      Name: 'África do Sul (+27)',
    },
    {
      Name: 'Albânia (+355)',
    },
    {
      Name: 'Alemanha (+49)',
    },
    {
      Name: 'Andorra (+376)',
    },
    {
      Name: 'Angola (+244)',
    },
    {
      Name: 'Anguilla (+1)',
    },
    {
      Name: 'Antígua e Barbuda (+1264)',
    },
    {
      Name: 'Antilhas Holandesas (+599)',
    },
    {
      Name: 'Arábia Saudita (+966)',
    },
    {
      Name: 'Argélia (+213)',
    },
    {
      Name: 'Argentina (+54)',
    },
    {
      Name: 'Armênia (+374)',
    },
    {
      Name: 'Aruba (+297)',
    },
    {
      Name: 'Ascensão (+247)',
    },
    {
      Name: 'Austrália (+61)',
    },
    {
      Name: 'Áustria (+43)',
    },
    {
      Name: 'Azerbaijão (+994)',
    },
    {
      Name: 'Bahamas (+1)',
    },
    {
      Name: 'Bangladesh (+880)',
    },
    {
      Name: 'Barbados (+1)',
    },
    {
      Name: 'Bahrein (+973)',
    },
    {
      Name: 'Bélgica (+32)',
    },
    {
      Name: 'Belize (+501)',
    },
    {
      Name: 'Benim (+229)',
    },
    {
      Name: 'Bermudas (+1)',
    },
    {
      Name: 'Bielorrússia (+375)',
    },
    {
      Name: 'Bolívia (+591)',
    },
    {
      Name: 'Bósnia e Herzegovina (+387)',
    },
    {
      Name: 'Botswana (+267)',
    },
    {
      Name: 'Brasil (+55)',
    },
    {
      Name: 'Brunei (+673)',
    },
    {
      Name: 'Bulgária (+359)',
    },
    {
      Name: 'Burkina Faso (+226)',
    },
    {
      Name: 'Burundi (+257)',
    },
    {
      Name: 'Butão (+975)',
    },
    {
      Name: 'Cabo Verde (+238)',
    },
    {
      Name: 'Camarões (+237)',
    },
    {
      Name: 'Camboja (+855)',
    },
    {
      Name: 'Canadá (+1)',
    },
    {
      Name: 'Cazaquistão (+7)',
    },
    {
      Name: 'Chade (+237)',
    },
    {
      Name: 'Chile (+56)',
    },
    {
      Name: 'República Popular da China (+86)',
    },
    {
      Name: 'Chipre (+357)',
    },
    {
      Name: 'Colômbia (+57)',
    },
    {
      Name: 'Comores (+269)',
    },
    {
      Name: 'Congo-Brazzaville (+242)',
    },
    {
      Name: 'Congo-Kinshasa (+243)',
    },
    {
      Name: 'Coreia do Norte (+850)',
    },
    {
      Name: 'Coreia do Sul (+82)',
    },
    {
      Name: 'Costa do Marfim (+225)',
    },
    {
      Name: 'Costa Rica (+506)',
    },
    {
      Name: 'Croácia (+385)',
    },
    {
      Name: 'Cuba (+53)',
    },
    {
      Name: 'Dinamarca (+45)',
    },
    {
      Name: 'Djibuti (+253)',
    },
    {
      Name: 'Dominica (+1)',
    },
    {
      Name: 'Egipto (+20)',
    },
    {
      Name: 'El Salvador (+503)',
    },
    {
      Name: 'Emirados Árabes Unidos (+971)',
    },
    {
      Name: 'Equador (+593)',
    },
    {
      Name: 'Eritreia (+291)',
    },
    {
      Name: 'Eslováquia (+421)',
    },
    {
      Name: 'Eslovénia (+386)',
    },
    {
      Name: 'Espanha (+34)',
    },
    {
      Name: 'Estados Unidos (+1)',
    },
    {
      Name: 'Estónia (+372)',
    },
    {
      Name: 'Etiópia (+251)',
    },
    {
      Name: 'Fiji (+679)',
    },
    {
      Name: 'Filipinas (+63)',
    },
    {
      Name: 'Finlândia (+358)',
    },
    {
      Name: 'França (+33)',
    },
    {
      Name: 'Gabão (+241)',
    },
    {
      Name: 'Gâmbia (+220)',
    },
    {
      Name: 'Gana (+233)',
    },
    {
      Name: 'Geórgia (+995)',
    },
    {
      Name: 'Gibraltar (+350)',
    },
    {
      Name: 'Granada (+1)',
    },
    {
      Name: 'Grécia (+30)',
    },
    {
      Name: 'Groenlândia (+299)',
    },
    {
      Name: 'Guadalupe (+590)',
    },

    {
      Name: 'Guam (+671)',
    },
    {
      Name: 'Guatemala (+502)',
    },
    {
      Name: 'Guiana (+592) ',
    },
    {
      Name: 'Guiana Francesa (+594)',
    },
    {
      Name: 'Guiné (+224)',
    },
    {
      Name: 'Guiné-Bissau (+245)',
    },
    {
      Name: 'Guiné Equatorial (+240)',
    },
    {
      Name: 'Haiti (+509)',
    },
    {
      Name: 'Honduras (+504)',
    },
    {
      Name: 'Hong Kong (+852)',
    },
    {
      Name: 'Hungria (+36)',
    },
    {
      Name: 'Iêmen (+967)',
    },
    {
      Name: 'Ilhas Cayman (+1)',
    },
    {
      Name: 'Ilha Christmas (+672)',
    },
    {
      Name: 'Ilhas Cocos (+672)',
    },
    {
      Name: 'Ilhas Cook (+682)',
    },
    {
      Name: 'Ilhas Féroe (+298)',
    },
    {
      Name: 'Ilha Heard e Ilhas McDonald (+672)',
    },
    {
      Name: 'Maldivas (+960)',
    },
    {
      Name: 'Ilhas Malvinas (+500)',
    },
    {
      Name: 'Ilhas Marianas do Norte (+1)',
    },
    {
      Name: 'Ilhas Marshall (+692)',
    },
    {
      Name: 'Ilha Norfolk (+672)',
    },
    {
      Name: 'Ilhas Salomão (+677)',
    },
    {
      Name: 'Ilhas Virgens Americanas (+1)',
    },
    {
      Name: 'Ilhas Virgens Britânicas (+1)',
    },
    {
      Name: 'Índia (+91)',
    },
    {
      Name: 'Indonésia (+62)',
    },
    {
      Name: 'Irã (+98)',
    },
    {
      Name: 'Iraque (+964)',
    },
    {
      Name: 'Irlanda (+353)',
    },
    {
      Name: 'Islândia (+354)',
    },
    {
      Name: 'Israel (+972)',
    },
    {
      Name: 'Itália (+39)',
    },
    {
      Name: 'Jamaica (+1)',
    },
    {
      Name: 'Japão (+81)',
    },
    {
      Name: 'Jordânia (+962)',
    },
    {
      Name: 'Kiribati (+686)',
    },
    {
      Name: 'Kosovo (+383)',
    },
    {
      Name: 'Kuwait (+965)',
    },
    {
      Name: 'Laos (+856)',
    },
    {
      Name: 'Lesoto (+266)',
    },
    {
      Name: 'Letônia (+371)',
    },
    {
      Name: 'Líbano (+961)',
    },
    {
      Name: 'Libéria (+231)',
    },
    {
      Name: 'Líbia (+218)',
    },
    {
      Name: 'Liechtenstein (+423)',
    },
    {
      Name: 'Lituânia (+370)',
    },
    {
      Name: 'Luxemburgo (+352)',
    },
    {
      Name: 'Macau (+853)',
    },
    {
      Name: 'Madagascar (+261)',
    },
    {
      Name: 'Malawi (+265)',
    },
    {
      Name: 'Mali (+223)',
    },
    {
      Name: 'Maurícia (+230)',
    },
    {
      Name: 'Mauritânia (+222)',
    },
    {
      Name: 'Mayotte (+269)',
    },
    {
      Name: 'México (+52)',
    },
    {
      Name: 'Estados Federados da Micronésia (+691)',
    },
    {
      Name: 'Moçambique (+258)',
    },
    {
      Name: 'Moldávia (+373)',
    },
    {
      Name: 'Mônaco (+377)',
    },
    {
      Name: 'Mongólia (+976)',
    },
    {
      Name: 'Montenegro (+382)',
    },
    {
      Name: 'Montserrat (+1)',
    },
    {
      Name: 'Myanmar (+95)',
    },
    {
      Name: 'Namíbia (+264)',
    },
    {
      Name: 'Nauru (+674)',
    },
    {
      Name: 'Nepal (+977)',
    },
    {
      Name: 'Nicarágua (+505)',
    },
    {
      Name: 'Níger (+227)',
    },
    {
      Name: 'Nigéria (+234)',
    },
    {
      Name: 'Niue (+683)',
    },
    {
      Name: 'Noruega (+47)',
    },
    {
      Name: 'Nova Caledônia (+687)',
    },
    {
      Name: 'Nova Zelândia (+64)',
    },
    {
      Name: 'Omã (+968)',
    },
    {
      Name: 'Países Baixos (+31)',
    },
    {
      Name: 'Palau (+680)',
    },
    {
      Name: 'Palestina (+970)',
    },
    {
      Name: 'Panamá (+507)',
    },
    {
      Name: 'Papua-Nova Guiné (+675)',
    },
    {
      Name: 'Paquistão (+92)',
    },
    {
      Name: 'Paraguai (+595)',
    },
    {
      Name: 'Peru (+51)',
    },
    {
      Name: 'Polinésia Francesa (+689)',
    },
    {
      Name: 'Polônia (+48)',
    },
    {
      Name: 'Porto Rico (+1)',
    },
    {
      Name: 'Portugal (+351)',
    },
    {
      Name: 'Qatar (+974)',
    },
    {
      Name: 'Quênia (+254)',
    },
    {
      Name: 'Quirguistão (+996)',
    },
    {
      Name: 'Reino Unido (+44)',
    },
    {
      Name: 'República Centro-Africana (+236)',
    },
    {
      Name: 'República Dominicana (+1)',
    },
    {
      Name: 'República Tcheca (+420)',
    },
    {
      Name: 'Reunião (+262)',
    },
    {
      Name: 'Romênia (+40)',
    },
    {
      Name: 'Ruanda (+250)',
    },
    {
      Name: 'Rússia (+7)',
    },
    {
      Name: 'Saara Ocidental (+212)',
    },
    {
      Name: 'Samoa (+685)',
    },
    {
      Name: 'Samoa Americana (+1)',
    },
    {
      Name: 'Santa Helena (território) (+290)',
    },
    {
      Name: 'Santa Lúcia (+1)',
    },
    {
      Name: 'São Cristóvão e Nevis (+1)',
    },
    {
      Name: 'São Marinho (+378)',
    },
    {
      Name: 'Saint-Pierre e Miquelon (+508)',
    },
    {
      Name: 'São Tomé e Príncipe (+239)',
    },
    {
      Name: 'São Vicente e Granadinas (+1)',
    },
    {
      Name: 'Seicheles (+248)',
    },
    {
      Name: 'Senegal (+221)',
    },
    {
      Name: 'Serra Leoa (+232)',
    },
    {
      Name: 'Sérvia (+381)',
    },
    {
      Name: 'Singapura (+65)',
    },
    {
      Name: 'Síria (+963)',
    },
    {
      Name: 'Somália (+252)',
    },
    {
      Name: 'Sri Lanka (+94)',
    },
    {
      Name: 'Suazilândia (+268)',
    },
    {
      Name: 'Sudão (+249)',
    },
    {
      Name: 'Sudão do Sul (+211)',
    },
    {
      Name: 'Suécia (+46)',
    },
    {
      Name: 'Suíça (+41)',
    },
    {
      Name: 'Suriname (+597)',
    },
    {
      Name: 'Tadjiquistão (+992)',
    },
    {
      Name: 'Tailândia (+66)',
    },
    {
      Name: 'República da China (+886)',
    },
    {
      Name: 'Tanzânia (+255)',
    },
    {
      Name: 'Território Britânico do Oceano Índico (+246)',
    },
    {
      Name: 'Timor-Leste (+670)',
    },
    {
      Name: 'Togo (+228)',
    },
    {
      Name: 'Tokelau (+690)',
    },
    {
      Name: 'Tonga (+676)',
    },
    {
      Name: 'Trinidad e Tobago (+1)',
    },
    {
      Name: 'Tunísia (+216)',
    },
    {
      Name: 'Turcas e Caicos (+1)',
    },
    {
      Name: 'Turquemenistão (+993)',
    },
    {
      Name: 'Turquia (+90)',
    },
    {
      Name: 'Tuvalu (+688)',
    },
    {
      Name: 'Ucrânia (+380)',
    },
    {
      Name: 'Uganda (+256)',
    },
    {
      Name: 'Uruguai (+598)',
    },
    {
      Name: 'Uzbequistão (+998)',
    },
    {
      Name: 'Vanuatu (+678)',
    },
    {
      Name: 'Vaticano (+379)',
    },
    {
      Name: 'Venezuela (+58)',
    },
    {
      Name: 'Vietnã (+84)',
    },
    {
      Name: 'Wallis e Futuna (+681)',
    },
    {
      Name: 'Zâmbia (+260)',
    },
    {
      Name: 'Zimbábue (+263)',
    },

  ];

  ngOnInit() {
    this.appTitle = 'PIX';
    this.profilePic = 'https://preview.fri.to/bradesco/profile.png';
    this.area = '+55';
    this.showFirstInput = true;
  }

  deleteNum() {
    (document.getElementById('input1') as HTMLInputElement).value = '';
  }

  deletePais() {
    (document.getElementById('input2') as HTMLInputElement).value = '';
  }

  setArea(area: string): void {
    area = area.substring(area.indexOf('(') + 1);
    area = area.trim();
    area = area.replace(')', '');
    this.area = area;

    this.showFirstInput = true;
  }

}
