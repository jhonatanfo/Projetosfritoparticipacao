import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { SemCadastrarDadosEncerrarComponent } from './sem-cadastrar-dados-encerrar.component';

describe('SemCadastrarDadosEncerrarComponent', () => {
  let component: SemCadastrarDadosEncerrarComponent;
  let fixture: ComponentFixture<SemCadastrarDadosEncerrarComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ SemCadastrarDadosEncerrarComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(SemCadastrarDadosEncerrarComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
