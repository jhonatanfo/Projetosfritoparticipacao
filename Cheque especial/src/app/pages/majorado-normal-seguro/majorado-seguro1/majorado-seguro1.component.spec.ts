import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { MajoradoSeguro1Component } from './majorado-seguro1.component';

describe('MajoradoSeguro1Component', () => {
  let component: MajoradoSeguro1Component;
  let fixture: ComponentFixture<MajoradoSeguro1Component>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ MajoradoSeguro1Component ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(MajoradoSeguro1Component);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
