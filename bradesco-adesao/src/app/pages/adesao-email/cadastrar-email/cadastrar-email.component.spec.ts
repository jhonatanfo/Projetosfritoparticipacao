import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { CadastrarEmailComponent } from './cadastrar-email.component';

describe('CadastrarEmailComponent', () => {
  let component: CadastrarEmailComponent;
  let fixture: ComponentFixture<CadastrarEmailComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ CadastrarEmailComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(CadastrarEmailComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
