import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { SelectPageComponent } from './pages/select-page.component';

// Adesão celular
import { BuscarPaisComponent } from './pages/adesao-celular/buscar-pais/buscar-pais.component';
import { IndexSwipeComponent } from './pages/adesao-celular/index-swipe/index-swipe.component';
import { DadosEncerrarComponent } from './pages/adesao-celular/dados-encerrar/dados-encerrar.component';
import { CadastrarComponent } from './pages/adesao-celular/cadastrar/cadastrar.component';
import { VincularChaveComponent } from './pages/adesao-celular/vincular-chave/vincular-chave.component';
import { ConfirmarComponent } from './pages/adesao-celular/confirmar/confirmar.component';
import { CadastradoSucessoComponent } from './pages/adesao-celular/cadastrado-sucesso/cadastrado-sucesso.component';
import { CadastrandoCelularComponent } from './pages/adesao-celular/cadastrando-celular/cadastrando-celular.component';
import { CadastrandoCelularConfirmacaoComponent } from './pages/adesao-celular/cadastrando-celular-confirmacao/cadastrando-celular-confirmacao.component';
// Adesão celular

// Adesão email
import { CadastrarEmailComponent } from './pages/adesao-email/cadastrar-email/cadastrar-email.component';
import { BuscarEmailComponent } from './pages/adesao-email/buscar-email/buscar-email.component';
import { CadastrandoEmailComponent } from './pages/adesao-email/cadastrando-email/cadastrando-email.component';
import { VincularChaveEmailComponent } from './pages/adesao-email/vincular-chave-email/vincular-chave-email.component';
import { CadastrandoEmailConfirmacaoComponent } from './pages/adesao-email/cadastrando-email-confirmacao/cadastrando-email-confirmacao.component';
import { ConfirmarEmailComponent } from './pages/adesao-email/confirmar-email/confirmar-email.component';
// Adesão email

// Adesão email e celular
import { BuscarEmailCelularComponent } from './pages/adesao-email-celular/buscar-email-celular/buscar-email-celular.component';
import { BuscarPaisEmailCelularComponent } from './pages/adesao-email-celular/buscar-pais-email-celular/buscar-pais-email-celular.component';
import { CadastrandoCodigoEmailCelularComponent } from './pages/adesao-email-celular/cadastrando-codigo-email-celular/cadastrando-codigo-email-celular.component';
import { CadastrandoEEmailCelularConfirmacaoComponent } from './pages/adesao-email-celular/cadastrando-e-email-celular-confirmacao/cadastrando-e-email-celular-confirmacao.component';
import { CadastrandoEmailCelularComponent } from './pages/adesao-email-celular/cadastrando-email-celular/cadastrando-email-celular.component';
import { CadastrandoEmailCelularConfirmacaoComponent } from './pages/adesao-email-celular/cadastrando-email-celular-confirmacao/cadastrando-email-celular-confirmacao.component';
import { CadastrarEmailCelularComponent } from './pages/adesao-email-celular/cadastrar-email-celular/cadastrar-email-celular.component';
import { ConfirmarEEmailCelularComponent } from './pages/adesao-email-celular/confirmar-e-email-celular/confirmar-e-email-celular.component';
import { DadosEncerrarEmailCelularComponent } from './pages/adesao-email-celular/dados-encerrar-email-celular/dados-encerrar-email-celular.component';
import { SucessoCadastroEmailCelularComponent } from './pages/adesao-email-celular/sucesso-cadastro-email-celular/sucesso-cadastro-email-celular.component';
import { VincularChaveEmailCelularComponent } from './pages/adesao-email-celular/vincular-chave-email-celular/vincular-chave-email-celular.component';
import { VincularchaveEEmailCelularComponent } from './pages/adesao-email-celular/vincularchave-e-email-celular/vincularchave-e-email-celular.component';
import { CadastrandoCodigoEEmailCelularComponent } from './pages/adesao-email-celular/cadastrando-codigo-e-email-celular/cadastrando-codigo-e-email-celular.component';
// Adesão email e celular

// Adesão cpf
import { CadastrarCpfComponent } from './pages/adesao-cpf/cadastrar-cpf/cadastrar-cpf.component';
import { ConfirmarCpfComponent } from './pages/adesao-cpf/confirmar-cpf/confirmar-cpf.component';
import { SucessoCadastroCpfComponent } from './pages/adesao-cpf/sucesso-cadastro-cpf/sucesso-cadastro-cpf.component';
import { VincularChaveCpfComponent } from './pages/adesao-cpf/vincular-chave-cpf/vincular-chave-cpf.component';
// Adesão cpf

// Adesão sem cadastrar
import { SemCadastrarComponent } from './pages/adesao-sem-cadastrar/sem-cadastrar/sem-cadastrar.component';
import { SemCadastrarDadosEncerrarComponent } from './pages/adesao-sem-cadastrar/sem-cadastrar-dados-encerrar/sem-cadastrar-dados-encerrar.component';
// Adesão sem cadastrar

const routes: Routes = [
  { path: '', component: SelectPageComponent },

  // Adesão celular
  { path: 'buscar-pais', component: BuscarPaisComponent },
  { path: 'index-celular', component: IndexSwipeComponent },
  { path: 'dados-encerrar', component: DadosEncerrarComponent },
  { path: 'cadastrar', component: CadastrarComponent },
  { path: 'vincular-chave', component: VincularChaveComponent },
  { path: 'confirmar', component: ConfirmarComponent },
  { path: 'sucesso-cadastro', component: CadastradoSucessoComponent },
  { path: 'cadastrando-celular', component: CadastrandoCelularComponent },
  { path: 'cadastrando-celular-confirmacao', component: CadastrandoCelularConfirmacaoComponent },
  // Adesão celular

  // Adesão email
  { path: 'cadastrar-email', component: CadastrarEmailComponent },
  { path: 'buscar-email', component: BuscarEmailComponent },
  { path: 'cadastrando-email-confirmacao', component: CadastrandoEmailConfirmacaoComponent },
  { path: 'cadastrando-email', component: CadastrandoEmailComponent },
  { path: 'confirmar-email', component: ConfirmarEmailComponent },
  { path: 'vincular-chave-email', component: VincularChaveEmailComponent },
  // Adesão email

  // Adesão email e celular
  { path: 'buscar-email-celular', component: BuscarEmailCelularComponent },
  { path: 'buscar-pais-email-celular', component: BuscarPaisEmailCelularComponent },
  { path: 'cadastrando-codigo-email-celular', component: CadastrandoCodigoEmailCelularComponent },
  { path: 'cadastrando-e-email-celular-confirmacao', component: CadastrandoEEmailCelularConfirmacaoComponent },
  { path: 'cadastrando-email-celular', component: CadastrandoEmailCelularComponent },
  { path: 'cadastrando-email-celular-confirmacao', component: CadastrandoEmailCelularConfirmacaoComponent },
  { path: 'cadastrar-email-celular', component: CadastrarEmailCelularComponent },
  { path: 'confirmar-e-email-celular', component: ConfirmarEEmailCelularComponent },
  { path: 'dados-encerrar-email-celular', component: DadosEncerrarEmailCelularComponent },
  { path: 'sucesso-cadastro-email-celular', component: SucessoCadastroEmailCelularComponent },
  { path: 'vincular-chave-email-celular', component: VincularChaveEmailCelularComponent },
  { path: 'vincularchave-e-email-celular', component: VincularchaveEEmailCelularComponent },
  { path: 'cadastrando-codigo-e-email-celular', component: CadastrandoCodigoEEmailCelularComponent },
  // Adesão email e celular

  // Adesão cpf
  { path: 'cadastrar-cpf', component: CadastrarCpfComponent },
  { path: 'confirmar-cpf', component: ConfirmarCpfComponent },
  { path: 'sucesso-cadastro-cpf', component: SucessoCadastroCpfComponent },
  { path: 'vincular-chave-cpf', component: VincularChaveCpfComponent },
  // Adesão cpf

  // Adesão sem cadastrar
  { path: 'sem-cadastrar', component: SemCadastrarComponent },
  { path: 'sem-cadastrar-dados-encerrar', component: SemCadastrarDadosEncerrarComponent },
  // Adesão sem cadastrar

];

@NgModule({
  imports: [RouterModule.forRoot(routes, { useHash: true })],
  exports: [RouterModule]
})
export class AppRoutingModule { }
