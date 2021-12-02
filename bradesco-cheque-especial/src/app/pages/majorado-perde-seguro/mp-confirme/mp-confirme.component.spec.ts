import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { MpConfirmeComponent } from './mp-confirme.component';

describe('MpConfirmeComponent', () => {
  let component: MpConfirmeComponent;
  let fixture: ComponentFixture<MpConfirmeComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ MpConfirmeComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(MpConfirmeComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
