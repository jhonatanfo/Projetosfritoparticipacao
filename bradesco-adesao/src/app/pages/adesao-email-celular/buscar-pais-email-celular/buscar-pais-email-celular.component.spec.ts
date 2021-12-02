import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { BuscarPaisEmailCelularComponent } from './buscar-pais-email-celular.component';

describe('BuscarPaisEmailCelularComponent', () => {
  let component: BuscarPaisEmailCelularComponent;
  let fixture: ComponentFixture<BuscarPaisEmailCelularComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ BuscarPaisEmailCelularComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(BuscarPaisEmailCelularComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
