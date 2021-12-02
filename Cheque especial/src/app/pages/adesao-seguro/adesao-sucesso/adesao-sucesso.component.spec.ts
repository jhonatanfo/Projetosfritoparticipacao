import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { AdesaoSucessoComponent } from './adesao-sucesso.component';

describe('AdesaoSucessoComponent', () => {
  let component: AdesaoSucessoComponent;
  let fixture: ComponentFixture<AdesaoSucessoComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ AdesaoSucessoComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(AdesaoSucessoComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
