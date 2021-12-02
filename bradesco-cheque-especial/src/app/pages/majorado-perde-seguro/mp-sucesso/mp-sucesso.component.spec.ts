import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { MpSucessoComponent } from './mp-sucesso.component';

describe('MpSucessoComponent', () => {
  let component: MpSucessoComponent;
  let fixture: ComponentFixture<MpSucessoComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ MpSucessoComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(MpSucessoComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
