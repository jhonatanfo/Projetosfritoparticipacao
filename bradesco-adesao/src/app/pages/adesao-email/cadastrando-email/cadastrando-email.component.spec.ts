import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { CadastrandoEmailComponent } from './cadastrando-email.component';

describe('CadastrandoEmailComponent', () => {
  let component: CadastrandoEmailComponent;
  let fixture: ComponentFixture<CadastrandoEmailComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ CadastrandoEmailComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(CadastrandoEmailComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
