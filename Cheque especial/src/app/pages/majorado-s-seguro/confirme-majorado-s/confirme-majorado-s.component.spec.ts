import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { ConfirmeMajoradoSComponent } from './confirme-majorado-s.component';

describe('ConfirmeMajoradoSComponent', () => {
  let component: ConfirmeMajoradoSComponent;
  let fixture: ComponentFixture<ConfirmeMajoradoSComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ ConfirmeMajoradoSComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(ConfirmeMajoradoSComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
