import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { Majorado1Component } from './majorado1.component';

describe('Majorado1Component', () => {
  let component: Majorado1Component;
  let fixture: ComponentFixture<Majorado1Component>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ Majorado1Component ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(Majorado1Component);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
