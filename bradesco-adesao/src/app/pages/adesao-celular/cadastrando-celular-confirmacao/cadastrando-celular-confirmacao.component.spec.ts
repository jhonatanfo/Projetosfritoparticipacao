import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { CadastrandoCelularConfirmacaoComponent } from './cadastrando-celular-confirmacao.component';

describe('CadastrandoCelularConfirmacaoComponent', () => {
  let component: CadastrandoCelularConfirmacaoComponent;
  let fixture: ComponentFixture<CadastrandoCelularConfirmacaoComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ CadastrandoCelularConfirmacaoComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(CadastrandoCelularConfirmacaoComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
