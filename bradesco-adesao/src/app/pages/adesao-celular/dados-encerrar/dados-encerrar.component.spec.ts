import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { DadosEncerrarComponent } from './dados-encerrar.component';

describe('DadosEncerrarComponent', () => {
  let component: DadosEncerrarComponent;
  let fixture: ComponentFixture<DadosEncerrarComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ DadosEncerrarComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(DadosEncerrarComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
