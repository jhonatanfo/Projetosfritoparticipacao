import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { CadastrandoCodigoEmailCelularComponent } from './cadastrando-codigo-email-celular.component';

describe('CadastrandoCodigoEmailCelularComponent', () => {
  let component: CadastrandoCodigoEmailCelularComponent;
  let fixture: ComponentFixture<CadastrandoCodigoEmailCelularComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ CadastrandoCodigoEmailCelularComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(CadastrandoCodigoEmailCelularComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
