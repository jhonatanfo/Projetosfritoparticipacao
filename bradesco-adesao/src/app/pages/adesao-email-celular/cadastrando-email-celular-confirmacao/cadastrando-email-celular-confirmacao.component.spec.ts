import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { CadastrandoEmailCelularConfirmacaoComponent } from './cadastrando-email-celular-confirmacao.component';

describe('CadastrandoEmailCelularConfirmacaoComponent', () => {
  let component: CadastrandoEmailCelularConfirmacaoComponent;
  let fixture: ComponentFixture<CadastrandoEmailCelularConfirmacaoComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ CadastrandoEmailCelularConfirmacaoComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(CadastrandoEmailCelularConfirmacaoComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
