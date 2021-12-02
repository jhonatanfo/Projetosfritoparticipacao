import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { MajoradoSSeguro1Component } from './majorado-s-seguro1.component';

describe('MajoradoSSeguro1Component', () => {
  let component: MajoradoSSeguro1Component;
  let fixture: ComponentFixture<MajoradoSSeguro1Component>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ MajoradoSSeguro1Component ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(MajoradoSSeguro1Component);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
