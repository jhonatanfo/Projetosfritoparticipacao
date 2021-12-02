import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { AndroidVersionComponent } from './android-version.component';

describe('AndroidVersionComponent', () => {
  let component: AndroidVersionComponent;
  let fixture: ComponentFixture<AndroidVersionComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ AndroidVersionComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(AndroidVersionComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
