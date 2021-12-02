import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { HeaderComponent } from './components/header/header.component';
import { SelectPageComponent } from './pages/select-page.component';
import { BuscarPaisComponent } from './pages/adesao-celular/buscar-pais/buscar-pais.component';

import { Ng2SearchPipeModule } from 'ng2-search-filter';
import { FormsModule } from '@angular/forms';
import { IndexSwipeComponent } from './pages/adesao-celular/index-swipe/index-swipe.component';
import { DadosEncerrarComponent } from './pages/adesao-celular/dados-encerrar/dados-encerrar.component';
import { VincularChaveComponent } from './pages/adesao-celular/vincular-chave/vincular-chave.component';

import { SlickCarouselModule } from 'ngx-slick-carousel';
import { BtnComponent } from './components/btn/btn.component';
import { CadastrarComponent } from './pages/adesao-celular/cadastrar/cadastrar.component';
import { ConfirmarComponent } from './pages/adesao-celular/confirmar/confirmar.component';
import { CadastradoSucessoComponent } from './pages/adesao-celular/cadastrado-sucesso/cadastrado-sucesso.component';
import { CadastrandoCelularComponent } from './pages/adesao-celular/cadastrando-celular/cadastrando-celular.component';
import { CadastrandoCelularConfirmacaoComponent } from './pages/adesao-celular/cadastrando-celular-confirmacao/cadastrando-celular-confirmacao.component';

import { CadastrarEmailComponent } from './pages/adesao-email/cadastrar-email/cadastrar-email.component';
import { BuscarEmailComponent } from './pages/adesao-email/buscar-email/buscar-email.component';
import { CadastrandoEmailComponent } from './pages/adesao-email/cadastrando-email/cadastrando-email.component';
import { CadastrandoEmailConfirmacaoComponent } from './pages/adesao-email/cadastrando-email-confirmacao/cadastrando-email-confirmacao.component';
import { VincularChaveEmailComponent } from './pages/adesao-email/vincular-chave-email/vincular-chave-email.component';
import { ConfirmarEmailComponent } from './pages/adesao-email/confirmar-email/confirmar-email.component';


import { CadastrarEmailCelularComponent } from './pages/adesao-email-celular/cadastrar-email-celular/cadastrar-email-celular.component';
import { BuscarPaisEmailCelularComponent } from './pages/adesao-email-celular/buscar-pais-email-celular/buscar-pais-email-celular.component';
import { CadastrandoEmailCelularComponent } from './pages/adesao-email-celular/cadastrando-email-celular/cadastrando-email-celular.component';
import { VincularChaveEmailCelularComponent } from './pages/adesao-email-celular/vincular-chave-email-celular/vincular-chave-email-celular.component';
import { CadastrandoEmailCelularConfirmacaoComponent } from './pages/adesao-email-celular/cadastrando-email-celular-confirmacao/cadastrando-email-celular-confirmacao.component';
import { BuscarEmailCelularComponent } from './pages/adesao-email-celular/buscar-email-celular/buscar-email-celular.component';
import { CadastrandoCodigoEmailCelularComponent } from './pages/adesao-email-celular/cadastrando-codigo-email-celular/cadastrando-codigo-email-celular.component';
import { VincularchaveEEmailCelularComponent } from './pages/adesao-email-celular/vincularchave-e-email-celular/vincularchave-e-email-celular.component';
import { CadastrandoEEmailCelularConfirmacaoComponent } from './pages/adesao-email-celular/cadastrando-e-email-celular-confirmacao/cadastrando-e-email-celular-confirmacao.component';
import { ConfirmarEEmailCelularComponent } from './pages/adesao-email-celular/confirmar-e-email-celular/confirmar-e-email-celular.component';
import { SucessoCadastroEmailCelularComponent } from './pages/adesao-email-celular/sucesso-cadastro-email-celular/sucesso-cadastro-email-celular.component';
import { DadosEncerrarEmailCelularComponent } from './pages/adesao-email-celular/dados-encerrar-email-celular/dados-encerrar-email-celular.component';
import { CadastrandoCodigoEEmailCelularComponent } from './pages/adesao-email-celular/cadastrando-codigo-e-email-celular/cadastrando-codigo-e-email-celular.component';

import { CadastrarCpfComponent } from './pages/adesao-cpf/cadastrar-cpf/cadastrar-cpf.component';
import { VincularChaveCpfComponent } from './pages/adesao-cpf/vincular-chave-cpf/vincular-chave-cpf.component';
import { ConfirmarCpfComponent } from './pages/adesao-cpf/confirmar-cpf/confirmar-cpf.component';
import { SucessoCadastroCpfComponent } from './pages/adesao-cpf/sucesso-cadastro-cpf/sucesso-cadastro-cpf.component';

import { SemCadastrarComponent } from './pages/adesao-sem-cadastrar/sem-cadastrar/sem-cadastrar.component';
import { SemCadastrarDadosEncerrarComponent } from './pages/adesao-sem-cadastrar/sem-cadastrar-dados-encerrar/sem-cadastrar-dados-encerrar.component';


@NgModule({
  declarations: [
    AppComponent,
    HeaderComponent,
    SelectPageComponent,
    BuscarPaisComponent,
    IndexSwipeComponent,
    DadosEncerrarComponent,
    VincularChaveComponent,
    BtnComponent,
    DadosEncerrarComponent,
    CadastrarComponent,
    ConfirmarComponent,
    CadastradoSucessoComponent,
    CadastrandoCelularComponent,
    CadastrandoCelularComponent,
    CadastrandoCelularConfirmacaoComponent,
    
    CadastrarEmailComponent,
    BuscarEmailComponent,
    CadastrandoEmailComponent,
    CadastrandoEmailConfirmacaoComponent,
    VincularChaveEmailComponent,
    ConfirmarEmailComponent,

    CadastrarEmailCelularComponent,
    BuscarPaisEmailCelularComponent,
    CadastrandoEmailCelularComponent,
    VincularChaveEmailCelularComponent,
    CadastrandoEmailCelularConfirmacaoComponent,
    BuscarEmailCelularComponent,
    CadastrandoCodigoEmailCelularComponent,
    VincularchaveEEmailCelularComponent,
    CadastrandoEEmailCelularConfirmacaoComponent,
    ConfirmarEEmailCelularComponent,
    SucessoCadastroEmailCelularComponent,
    DadosEncerrarEmailCelularComponent,
    CadastrandoCodigoEEmailCelularComponent,
    CadastrarCpfComponent,
    VincularChaveCpfComponent,
    ConfirmarCpfComponent,
    SucessoCadastroCpfComponent,
    SemCadastrarComponent,
    SemCadastrarDadosEncerrarComponent,
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    Ng2SearchPipeModule,
    FormsModule,
    SlickCarouselModule,
  ],
  providers: [],
  bootstrap: [AppComponent]
})
export class AppModule { }
