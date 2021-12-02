import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { CardLongComponent } from './card-long.component';

describe('CardLongComponent', () => {
  let component: CardLongComponent;
  let fixture: ComponentFixture<CardLongComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ CardLongComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(CardLongComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
