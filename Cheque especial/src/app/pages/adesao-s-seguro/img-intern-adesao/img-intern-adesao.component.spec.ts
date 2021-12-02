import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { ImgInternAdesaoComponent } from './img-intern-adesao.component';

describe('ImgInternAdesaoComponent', () => {
  let component: ImgInternAdesaoComponent;
  let fixture: ComponentFixture<ImgInternAdesaoComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ ImgInternAdesaoComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(ImgInternAdesaoComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
