import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { IndexMajoradoSSeguroComponent } from './index-majorado-s-seguro.component';

describe('IndexMajoradoSSeguroComponent', () => {
  let component: IndexMajoradoSSeguroComponent;
  let fixture: ComponentFixture<IndexMajoradoSSeguroComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ IndexMajoradoSSeguroComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(IndexMajoradoSSeguroComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
