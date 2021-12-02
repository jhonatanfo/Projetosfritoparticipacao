import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { CadastrandoEmailCelularComponent } from './cadastrando-email-celular.component';

describe('CadastrandoEmailCelularComponent', () => {
  let component: CadastrandoEmailCelularComponent;
  let fixture: ComponentFixture<CadastrandoEmailCelularComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ CadastrandoEmailCelularComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(CadastrandoEmailCelularComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
