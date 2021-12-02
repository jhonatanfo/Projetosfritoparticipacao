import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { ConfirmeMajoradoComponent } from './confirme-majorado.component';

describe('ConfirmeMajoradoComponent', () => {
  let component: ConfirmeMajoradoComponent;
  let fixture: ComponentFixture<ConfirmeMajoradoComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ ConfirmeMajoradoComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(ConfirmeMajoradoComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
