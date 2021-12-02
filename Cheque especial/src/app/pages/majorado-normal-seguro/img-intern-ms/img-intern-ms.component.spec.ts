import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { ImgInternMsComponent } from './img-intern-ms.component';

describe('ImgInternMsComponent', () => {
  let component: ImgInternMsComponent;
  let fixture: ComponentFixture<ImgInternMsComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ ImgInternMsComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(ImgInternMsComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
