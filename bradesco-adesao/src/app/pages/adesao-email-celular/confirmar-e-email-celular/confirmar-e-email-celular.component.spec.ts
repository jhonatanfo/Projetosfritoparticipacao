import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { ConfirmarEEmailCelularComponent } from './confirmar-e-email-celular.component';

describe('ConfirmarEEmailCelularComponent', () => {
  let component: ConfirmarEEmailCelularComponent;
  let fixture: ComponentFixture<ConfirmarEEmailCelularComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ ConfirmarEEmailCelularComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(ConfirmarEEmailCelularComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
