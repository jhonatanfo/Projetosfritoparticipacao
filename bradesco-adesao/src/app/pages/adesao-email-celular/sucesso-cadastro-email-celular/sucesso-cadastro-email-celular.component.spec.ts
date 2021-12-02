import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { SucessoCadastroEmailCelularComponent } from './sucesso-cadastro-email-celular.component';

describe('SucessoCadastroEmailCelularComponent', () => {
  let component: SucessoCadastroEmailCelularComponent;
  let fixture: ComponentFixture<SucessoCadastroEmailCelularComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ SucessoCadastroEmailCelularComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(SucessoCadastroEmailCelularComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
