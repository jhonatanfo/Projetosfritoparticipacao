import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { CadastrandoEEmailCelularConfirmacaoComponent } from './cadastrando-e-email-celular-confirmacao.component';

describe('CadastrandoEEmailCelularConfirmacaoComponent', () => {
  let component: CadastrandoEEmailCelularConfirmacaoComponent;
  let fixture: ComponentFixture<CadastrandoEEmailCelularConfirmacaoComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ CadastrandoEEmailCelularConfirmacaoComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(CadastrandoEEmailCelularConfirmacaoComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
