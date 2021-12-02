import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { ConfirmeAdesaoComponent } from './confirme-adesao.component';

describe('ConfirmeAdesaoComponent', () => {
  let component: ConfirmeAdesaoComponent;
  let fixture: ComponentFixture<ConfirmeAdesaoComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ ConfirmeAdesaoComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(ConfirmeAdesaoComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
