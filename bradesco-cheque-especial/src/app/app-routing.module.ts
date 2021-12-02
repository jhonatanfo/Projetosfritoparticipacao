import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { SelectPageComponent } from './pages/select-page.component';

import { IndexAdesaoSeguro } from './pages/adesao-seguro/index-adesao-seguro/index-adesao-seguro.component';
import { ImgInternComponent } from './pages/adesao-seguro/img-intern/img-intern.component';
import { IndexMajoradoSeguroComponent } from './pages/majorado-normal-seguro/index-majorado-seguro/index-majorado-seguro.component';
import { ImgInternMsComponent } from './pages/majorado-normal-seguro/img-intern-ms/img-intern-ms.component';

import { AdesaoSeguro1Component } from './pages/adesao-seguro/adesao-seguro1/adesao-seguro1.component';
import { ConfirmeAdesaoComponent } from './pages/adesao-seguro/confirme-adesao/confirme-adesao.component';
import { AdesaoSucessoComponent } from './pages/adesao-seguro/adesao-sucesso/adesao-sucesso.component';

import { MajoradoSeguro1Component } from './pages/majorado-normal-seguro/majorado-seguro1/majorado-seguro1.component';
import { ConfirmeMajoradoComponent } from './pages/majorado-normal-seguro/confirme-majorado/confirme-majorado.component';
import { MajoradoSucessoComponent } from './pages/majorado-normal-seguro/majorado-sucesso/majorado-sucesso.component';

import { IndexAdesaoComponent } from './pages/adesao-s-seguro/index-adesao/index-adesao.component';
import { ImgInternAdesaoComponent } from './pages/adesao-s-seguro/img-intern-adesao/img-intern-adesao.component';
import { AdesaoSSeguro1Component } from './pages/adesao-s-seguro/adesao-s-seguro1/adesao-s-seguro1.component';
import { ConfirmeAdesaoSSeguroComponent } from './pages/adesao-s-seguro/confirme-adesao-s-seguro/confirme-adesao-s-seguro.component';
import { AdesaoSSucessoComponent } from './pages/adesao-s-seguro/adesao-s-sucesso/adesao-s-sucesso.component';

import { Mp1Component } from './pages/majorado-perde-seguro/mp1/mp1.component';
import { MpConfirmeComponent } from './pages/majorado-perde-seguro/mp-confirme/mp-confirme.component';
import { MpSucessoComponent } from './pages/majorado-perde-seguro/mp-sucesso/mp-sucesso.component';
import { ImgInternMpComponent } from './pages/majorado-perde-seguro/img-intern-mp/img-intern-mp.component';
import { IndexMpComponent } from './pages/majorado-perde-seguro/index-mp/index-mp.component';

import { IndexMajoradoFaixaComponent } from './pages/majorado-faixa/index-majorado-faixa/index-majorado-faixa.component';
import { ImgInternMfComponent } from './pages/majorado-faixa/img-intern-mf/img-intern-mf.component';
import { Majorado1Component } from './pages/majorado-faixa/majorado1/majorado1.component';
import { MajoradoConfirmeFxComponent } from './pages/majorado-faixa/majorado-confirme-fx/majorado-confirme-fx.component';
import { MajoradoSucessoFxComponent } from './pages/majorado-faixa/majorado-sucesso-fx/majorado-sucesso-fx.component';
import { IndexMajoradoSSeguroComponent } from './pages/majorado-s-seguro/index-majorado-s-seguro/index-majorado-s-seguro.component';
import { ImgInternMssComponent } from './pages/majorado-s-seguro/img-intern-mss/img-intern-mss.component';
import { ConfirmeMajoradoSComponent } from './pages/majorado-s-seguro/confirme-majorado-s/confirme-majorado-s.component';
import { MajoradoSSeguroSucessoComponent } from './pages/majorado-s-seguro/majorado-s-seguro-sucesso/majorado-s-seguro-sucesso.component';
import { MajoradoSSeguro1Component } from './pages/majorado-s-seguro/majorado-s-seguro1/majorado-s-seguro1.component';

const routes: Routes = [

  { path: '', component: SelectPageComponent },

  { path: 'adesao-s', component: IndexAdesaoSeguro },
  { path: 'adesao', component: IndexAdesaoComponent },
  
  { path: 'interna-adesao-seguro', component: ImgInternComponent },
  { path: 'adesao-seguro', component: AdesaoSeguro1Component },
  { path: 'confirme-seguro', component: ConfirmeAdesaoComponent },
  { path: 'sucesso-seguro', component: AdesaoSucessoComponent },

  { path: 'interna-adesao', component: ImgInternAdesaoComponent },
  { path: 'adesao-sem-seguro', component: AdesaoSSeguro1Component },
  { path: 'confirme-s-seguro', component: ConfirmeAdesaoSSeguroComponent },
  { path: 'sucesso-s-seguro', component: AdesaoSSucessoComponent },

  { path: 'majorado-s', component: IndexMajoradoSeguroComponent },
  { path: 'interna-majorado-seguro', component: ImgInternMsComponent },
  { path: 'majorado-seguro', component: MajoradoSeguro1Component },
  { path: 'confirme-majorado', component: ConfirmeMajoradoComponent },
  { path: 'sucesso-majorado', component: MajoradoSucessoComponent },

  { path: 'majorado-s-seguro', component: IndexMajoradoSSeguroComponent },
  { path: 'interna-majorado-s-seguro', component: ImgInternMssComponent },
  { path: 'majorado-ss', component: MajoradoSSeguro1Component },
  { path: 'confirme-majorado-s', component: ConfirmeMajoradoSComponent },
  { path: 'sucesso-majorado-s', component: MajoradoSSeguroSucessoComponent },

  { path: 'majorado-perde-s', component: IndexMpComponent },
  { path: 'majorado-perde-seguro', component: Mp1Component },
  { path: 'confirme-majorado-perde-seguro', component: MpConfirmeComponent },
  { path: 'majorado-perde-seguro-sucesso', component: MpSucessoComponent },
  { path: 'interna-majorado-perde-seguro', component: ImgInternMpComponent },

  { path: 'majorado-faixa', component: IndexMajoradoFaixaComponent },
  { path: 'interna-majorado-faixa', component: ImgInternMfComponent },
  { path: 'majorado-faixa1', component: Majorado1Component },
  { path: 'majorado-confirme-fx', component: MajoradoConfirmeFxComponent },
  { path: 'majorado-sucesso-fx', component: MajoradoSucessoFxComponent },
];

@NgModule({
  imports: [RouterModule.forRoot(routes, { useHash: true })],
  exports: [RouterModule]
})

export class AppRoutingModule { }
