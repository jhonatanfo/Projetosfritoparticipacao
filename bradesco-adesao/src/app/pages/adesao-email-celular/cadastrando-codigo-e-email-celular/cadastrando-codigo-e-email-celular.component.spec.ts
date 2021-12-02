import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { CadastrandoCodigoEEmailCelularComponent } from './cadastrando-codigo-e-email-celular.component';

describe('CadastrandoCodigoEEmailCelularComponent', () => {
  let component: CadastrandoCodigoEEmailCelularComponent;
  let fixture: ComponentFixture<CadastrandoCodigoEEmailCelularComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ CadastrandoCodigoEEmailCelularComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(CadastrandoCodigoEEmailCelularComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
