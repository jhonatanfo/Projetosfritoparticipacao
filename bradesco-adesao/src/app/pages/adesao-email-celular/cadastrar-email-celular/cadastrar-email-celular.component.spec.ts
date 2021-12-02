import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { CadastrarEmailCelularComponent } from './cadastrar-email-celular.component';

describe('CadastrarEmailCelularComponent', () => {
  let component: CadastrarEmailCelularComponent;
  let fixture: ComponentFixture<CadastrarEmailCelularComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ CadastrarEmailCelularComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(CadastrarEmailCelularComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
