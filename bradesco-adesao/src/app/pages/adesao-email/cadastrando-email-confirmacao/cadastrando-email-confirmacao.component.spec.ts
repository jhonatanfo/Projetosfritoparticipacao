import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { CadastrandoEmailConfirmacaoComponent } from './cadastrando-email-confirmacao.component';

describe('CadastrandoEmailConfirmacaoComponent', () => {
  let component: CadastrandoEmailConfirmacaoComponent;
  let fixture: ComponentFixture<CadastrandoEmailConfirmacaoComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ CadastrandoEmailConfirmacaoComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(CadastrandoEmailConfirmacaoComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
