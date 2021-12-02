import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { CadastrandoCelularComponent } from './cadastrando-celular.component';

describe('CadastrandoCelularComponent', () => {
  let component: CadastrandoCelularComponent;
  let fixture: ComponentFixture<CadastrandoCelularComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ CadastrandoCelularComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(CadastrandoCelularComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
