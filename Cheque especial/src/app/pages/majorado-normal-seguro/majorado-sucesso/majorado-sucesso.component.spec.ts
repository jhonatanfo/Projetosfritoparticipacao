import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { MajoradoSucessoComponent } from './majorado-sucesso.component';

describe('MajoradoSucessoComponent', () => {
  let component: MajoradoSucessoComponent;
  let fixture: ComponentFixture<MajoradoSucessoComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ MajoradoSucessoComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(MajoradoSucessoComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
