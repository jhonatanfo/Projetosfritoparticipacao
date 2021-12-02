import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { AdesaoSSucessoComponent } from './adesao-s-sucesso.component';

describe('AdesaoSSucessoComponent', () => {
  let component: AdesaoSSucessoComponent;
  let fixture: ComponentFixture<AdesaoSSucessoComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ AdesaoSSucessoComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(AdesaoSSucessoComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
