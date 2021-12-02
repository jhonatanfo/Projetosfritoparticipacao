import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { SucessoCadastroCpfComponent } from './sucesso-cadastro-cpf.component';

describe('SucessoCadastroCpfComponent', () => {
  let component: SucessoCadastroCpfComponent;
  let fixture: ComponentFixture<SucessoCadastroCpfComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ SucessoCadastroCpfComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(SucessoCadastroCpfComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
