import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { DadosEncerrarEmailCelularComponent } from './dados-encerrar-email-celular.component';

describe('DadosEncerrarEmailCelularComponent', () => {
  let component: DadosEncerrarEmailCelularComponent;
  let fixture: ComponentFixture<DadosEncerrarEmailCelularComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ DadosEncerrarEmailCelularComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(DadosEncerrarEmailCelularComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
