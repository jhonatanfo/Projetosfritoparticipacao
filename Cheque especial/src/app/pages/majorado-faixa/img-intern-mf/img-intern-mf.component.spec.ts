import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { ImgInternMfComponent } from './img-intern-mf.component';

describe('ImgInternMfComponent', () => {
  let component: ImgInternMfComponent;
  let fixture: ComponentFixture<ImgInternMfComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ ImgInternMfComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(ImgInternMfComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
