import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { BuscarEmailCelularComponent } from './buscar-email-celular.component';

describe('BuscarEmailCelularComponent', () => {
  let component: BuscarEmailCelularComponent;
  let fixture: ComponentFixture<BuscarEmailCelularComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ BuscarEmailCelularComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(BuscarEmailCelularComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
