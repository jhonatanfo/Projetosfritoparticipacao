import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { Mp1Component } from './mp1.component';

describe('Mp1Component', () => {
  let component: Mp1Component;
  let fixture: ComponentFixture<Mp1Component>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ Mp1Component ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(Mp1Component);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
