import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { ImgInternMpComponent } from './img-intern-mp.component';

describe('ImgInternMpComponent', () => {
  let component: ImgInternMpComponent;
  let fixture: ComponentFixture<ImgInternMpComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ ImgInternMpComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(ImgInternMpComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
