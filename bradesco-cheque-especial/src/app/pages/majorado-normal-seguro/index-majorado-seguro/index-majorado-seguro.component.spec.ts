import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { IndexMajoradoSeguroComponent } from './index-majorado-seguro.component';

describe('IndexMajoradoSeguroComponent', () => {
  let component: IndexMajoradoSeguroComponent;
  let fixture: ComponentFixture<IndexMajoradoSeguroComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ IndexMajoradoSeguroComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(IndexMajoradoSeguroComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
