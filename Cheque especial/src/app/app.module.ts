import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';

import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';

// COMPONENTES
import { HeaderMenuComponent } from './components/header-menu/header-menu.component';
import { BtnConfirmComponent } from './components/btn-confirm/btn-confirm.component';
import { AlertComponent } from './components/alert/alert.component';

// PÁGINAS
import { IndexAdesaoSeguro } from './pages/adesao-seguro/index-adesao-seguro/index-adesao-seguro.component';
import { AdesaoSeguro1Component } from './pages/adesao-seguro/adesao-seguro1/adesao-seguro1.component';
import { ConfirmeAdesaoComponent } from './pages/adesao-seguro/confirme-adesao/confirme-adesao.component';
import { AdesaoSucessoComponent } from './pages/adesao-seguro/adesao-sucesso/adesao-sucesso.component';
import { MajoradoSeguro1Component } from './pages/majorado-normal-seguro/majorado-seguro1/majorado-seguro1.component';
import { ConfirmeMajoradoComponent } from './pages/majorado-normal-seguro/confirme-majorado/confirme-majorado.component';
import { MajoradoSucessoComponent } from './pages/majorado-normal-seguro/majorado-sucesso/majorado-sucesso.component';
import { ModalIndexComponent } from './components/modal-index/modal-index.component';
import { ImgInternComponent } from './pages/adesao-seguro/img-intern/img-intern.component';
import { IndexMajoradoSeguroComponent } from './pages/majorado-normal-seguro/index-majorado-seguro/index-majorado-seguro.component';
import { ImgInternMsComponent } from './pages/majorado-normal-seguro/img-intern-ms/img-intern-ms.component';
import { IndexAdesaoComponent } from './pages/adesao-s-seguro/index-adesao/index-adesao.component';
import { ImgInternAdesaoComponent } from './pages/adesao-s-seguro/img-intern-adesao/img-intern-adesao.component';
import { AdesaoSSeguro1Component } from './pages/adesao-s-seguro/adesao-s-seguro1/adesao-s-seguro1.component';
import { ConfirmeAdesaoSSeguroComponent } from './pages/adesao-s-seguro/confirme-adesao-s-seguro/confirme-adesao-s-seguro.component';
import { AdesaoSSucessoComponent } from './pages/adesao-s-seguro/adesao-s-sucesso/adesao-s-sucesso.component';
import { Mp1Component } from './pages/majorado-perde-seguro/mp1/mp1.component';
import { MpConfirmeComponent } from './pages/majorado-perde-seguro/mp-confirme/mp-confirme.component';
import { MpSucessoComponent } from './pages/majorado-perde-seguro/mp-sucesso/mp-sucesso.component';
import { IndexMpComponent } from './pages/majorado-perde-seguro/index-mp/index-mp.component';
import { ImgInternMpComponent } from './pages/majorado-perde-seguro/img-intern-mp/img-intern-mp.component';
import { IndexMajoradoFaixaComponent } from './pages/majorado-faixa/index-majorado-faixa/index-majorado-faixa.component';
import { ImgInternMfComponent } from './pages/majorado-faixa/img-intern-mf/img-intern-mf.component';
import { Majorado1Component } from './pages/majorado-faixa/majorado1/majorado1.component';
import { MajoradoConfirmeFxComponent } from './pages/majorado-faixa/majorado-confirme-fx/majorado-confirme-fx.component';
import { MajoradoSucessoFxComponent } from './pages/majorado-faixa/majorado-sucesso-fx/majorado-sucesso-fx.component';
import { SelectPageComponent } from './pages/select-page.component';
import { ConfirmeMajoradoSComponent } from './pages/majorado-s-seguro/confirme-majorado-s/confirme-majorado-s.component';
import { ImgInternMssComponent } from './pages/majorado-s-seguro/img-intern-mss/img-intern-mss.component';
import { IndexMajoradoSSeguroComponent } from './pages/majorado-s-seguro/index-majorado-s-seguro/index-majorado-s-seguro.component';
import { MajoradoSSeguro1Component } from './pages/majorado-s-seguro/majorado-s-seguro1/majorado-s-seguro1.component';
import { MajoradoSSeguroSucessoComponent } from './pages/majorado-s-seguro/majorado-s-seguro-sucesso/majorado-s-seguro-sucesso.component';

@NgModule({
  declarations: [
    AppComponent,
    HeaderMenuComponent,
    IndexAdesaoSeguro,
    AdesaoSeguro1Component,
    BtnConfirmComponent,
    ConfirmeAdesaoComponent,
    AdesaoSucessoComponent,
    AlertComponent,
    MajoradoSeguro1Component,
    ConfirmeMajoradoComponent,
    MajoradoSucessoComponent,
    ModalIndexComponent,
    ImgInternComponent,
    IndexMajoradoSeguroComponent,
    ImgInternMsComponent,
    IndexAdesaoComponent,
    ImgInternAdesaoComponent,
    AdesaoSSeguro1Component,
    ConfirmeAdesaoSSeguroComponent,
    AdesaoSSucessoComponent,
    Mp1Component,
    MpConfirmeComponent,
    MpSucessoComponent,
    IndexMpComponent,
    ImgInternMpComponent,
    IndexMajoradoFaixaComponent,
    ImgInternMfComponent,
    Majorado1Component,
    MajoradoConfirmeFxComponent,
    MajoradoSucessoFxComponent,
    SelectPageComponent,
    ConfirmeMajoradoSComponent,
    ImgInternMssComponent,
    IndexMajoradoSSeguroComponent,
    MajoradoSSeguro1Component,
    MajoradoSSeguroSucessoComponent,
  ],
  imports: [
    BrowserModule,
    AppRoutingModule
  ],
  providers: [],
  bootstrap: [AppComponent]
})
export class AppModule { }
