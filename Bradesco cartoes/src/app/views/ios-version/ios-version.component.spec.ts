import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { IosVersionComponent } from './ios-version.component';

describe('IosVersionComponent', () => {
  let component: IosVersionComponent;
  let fixture: ComponentFixture<IosVersionComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ IosVersionComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(IosVersionComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
