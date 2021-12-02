import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { ImgInternMssComponent } from './img-intern-mss.component';

describe('ImgInternMssComponent', () => {
  let component: ImgInternMssComponent;
  let fixture: ComponentFixture<ImgInternMssComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ ImgInternMssComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(ImgInternMssComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
