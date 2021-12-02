import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { ImgInternComponent } from './img-intern.component';

describe('ImgInternComponent', () => {
  let component: ImgInternComponent;
  let fixture: ComponentFixture<ImgInternComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ ImgInternComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(ImgInternComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
