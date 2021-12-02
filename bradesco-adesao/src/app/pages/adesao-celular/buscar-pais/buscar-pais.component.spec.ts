import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { BuscarPaisComponent } from './buscar-pais.component';

describe('BuscarPaisComponent', () => {
  let component: BuscarPaisComponent;
  let fixture: ComponentFixture<BuscarPaisComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ BuscarPaisComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(BuscarPaisComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
