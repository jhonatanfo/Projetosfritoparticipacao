import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { ConfirmarCpfComponent } from './confirmar-cpf.component';

describe('ConfirmarCpfComponent', () => {
  let component: ConfirmarCpfComponent;
  let fixture: ComponentFixture<ConfirmarCpfComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ ConfirmarCpfComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(ConfirmarCpfComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
