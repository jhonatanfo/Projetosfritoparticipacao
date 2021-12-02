import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { CadastrarCpfComponent } from './cadastrar-cpf.component';

describe('CadastrarCpfComponent', () => {
  let component: CadastrarCpfComponent;
  let fixture: ComponentFixture<CadastrarCpfComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ CadastrarCpfComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(CadastrarCpfComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
