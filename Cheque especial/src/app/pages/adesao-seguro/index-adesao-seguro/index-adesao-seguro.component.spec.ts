import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { IndexAdesaoSeguro } from './index-adesao-seguro.component';

describe('IndexComponent', () => {
  let component: IndexAdesaoSeguro;
  let fixture: ComponentFixture<IndexAdesaoSeguro>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ IndexAdesaoSeguro ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(IndexAdesaoSeguro);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
