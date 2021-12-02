import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { CadastradoSucessoComponent } from './cadastrado-sucesso.component';

describe('CadastradoSucessoComponent', () => {
  let component: CadastradoSucessoComponent;
  let fixture: ComponentFixture<CadastradoSucessoComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ CadastradoSucessoComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(CadastradoSucessoComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
