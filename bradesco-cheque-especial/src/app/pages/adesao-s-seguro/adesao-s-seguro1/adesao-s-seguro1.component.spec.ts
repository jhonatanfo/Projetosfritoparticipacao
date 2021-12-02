import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { AdesaoSSeguro1Component } from './adesao-s-seguro1.component';

describe('AdesaoSSeguro1Component', () => {
  let component: AdesaoSSeguro1Component;
  let fixture: ComponentFixture<AdesaoSSeguro1Component>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ AdesaoSSeguro1Component ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(AdesaoSSeguro1Component);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
