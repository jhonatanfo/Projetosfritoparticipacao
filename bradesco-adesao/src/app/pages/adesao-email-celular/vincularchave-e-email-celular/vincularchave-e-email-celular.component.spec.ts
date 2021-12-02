import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { VincularchaveEEmailCelularComponent } from './vincularchave-e-email-celular.component';

describe('VincularchaveEEmailCelularComponent', () => {
  let component: VincularchaveEEmailCelularComponent;
  let fixture: ComponentFixture<VincularchaveEEmailCelularComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ VincularchaveEEmailCelularComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(VincularchaveEEmailCelularComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
