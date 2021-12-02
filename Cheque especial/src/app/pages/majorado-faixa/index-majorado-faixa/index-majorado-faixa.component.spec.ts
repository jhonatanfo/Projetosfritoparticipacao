import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { IndexMajoradoFaixaComponent } from './index-majorado-faixa.component';

describe('IndexMajoradoFaixaComponent', () => {
  let component: IndexMajoradoFaixaComponent;
  let fixture: ComponentFixture<IndexMajoradoFaixaComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ IndexMajoradoFaixaComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(IndexMajoradoFaixaComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
