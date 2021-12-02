import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { ConfirmeAdesaoSSeguroComponent } from './confirme-adesao-s-seguro.component';

describe('ConfirmeAdesaoSSeguroComponent', () => {
  let component: ConfirmeAdesaoSSeguroComponent;
  let fixture: ComponentFixture<ConfirmeAdesaoSSeguroComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ ConfirmeAdesaoSSeguroComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(ConfirmeAdesaoSSeguroComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
