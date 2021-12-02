import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { MajoradoSucessoFxComponent } from './majorado-sucesso-fx.component';

describe('MajoradoSucessoFxComponent', () => {
  let component: MajoradoSucessoFxComponent;
  let fixture: ComponentFixture<MajoradoSucessoFxComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ MajoradoSucessoFxComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(MajoradoSucessoFxComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
