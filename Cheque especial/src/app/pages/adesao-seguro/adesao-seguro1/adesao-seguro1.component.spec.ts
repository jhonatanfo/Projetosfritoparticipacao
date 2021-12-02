import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { AdesaoSeguro1Component } from './adesao-seguro1.component';

describe('AdesaoSeguro1Component', () => {
  let component: AdesaoSeguro1Component;
  let fixture: ComponentFixture<AdesaoSeguro1Component>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ AdesaoSeguro1Component ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(AdesaoSeguro1Component);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
