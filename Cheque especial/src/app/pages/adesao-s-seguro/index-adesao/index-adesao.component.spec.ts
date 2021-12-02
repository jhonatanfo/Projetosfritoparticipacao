import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { IndexAdesaoComponent } from './index-adesao.component';

describe('IndexAdesaoComponent', () => {
  let component: IndexAdesaoComponent;
  let fixture: ComponentFixture<IndexAdesaoComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ IndexAdesaoComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(IndexAdesaoComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
