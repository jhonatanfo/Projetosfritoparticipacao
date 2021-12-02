import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { MajoradoSSeguroSucessoComponent } from './majorado-s-seguro-sucesso.component';

describe('MajoradoSSeguroSucessoComponent', () => {
  let component: MajoradoSSeguroSucessoComponent;
  let fixture: ComponentFixture<MajoradoSSeguroSucessoComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ MajoradoSSeguroSucessoComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(MajoradoSSeguroSucessoComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
