import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { IndexSwipeComponent } from './index-swipe.component';

describe('IndexSwipeComponent', () => {
  let component: IndexSwipeComponent;
  let fixture: ComponentFixture<IndexSwipeComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ IndexSwipeComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(IndexSwipeComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
