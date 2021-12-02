import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { IndexMpComponent } from './index-mp.component';

describe('IndexMpComponent', () => {
  let component: IndexMpComponent;
  let fixture: ComponentFixture<IndexMpComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ IndexMpComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(IndexMpComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
