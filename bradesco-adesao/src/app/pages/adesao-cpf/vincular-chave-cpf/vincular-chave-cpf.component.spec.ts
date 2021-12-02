import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { VincularChaveCpfComponent } from './vincular-chave-cpf.component';

describe('VincularChaveCpfComponent', () => {
  let component: VincularChaveCpfComponent;
  let fixture: ComponentFixture<VincularChaveCpfComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ VincularChaveCpfComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(VincularChaveCpfComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
