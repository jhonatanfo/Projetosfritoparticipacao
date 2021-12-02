import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { VincularChaveEmailCelularComponent } from './vincular-chave-email-celular.component';

describe('VincularChaveEmailCelularComponent', () => {
  let component: VincularChaveEmailCelularComponent;
  let fixture: ComponentFixture<VincularChaveEmailCelularComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ VincularChaveEmailCelularComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(VincularChaveEmailCelularComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
