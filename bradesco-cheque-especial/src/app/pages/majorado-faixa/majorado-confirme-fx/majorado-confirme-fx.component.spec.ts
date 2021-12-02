import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { MajoradoConfirmeFxComponent } from './majorado-confirme-fx.component';

describe('MajoradoConfirmeFxComponent', () => {
  let component: MajoradoConfirmeFxComponent;
  let fixture: ComponentFixture<MajoradoConfirmeFxComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ MajoradoConfirmeFxComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(MajoradoConfirmeFxComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
