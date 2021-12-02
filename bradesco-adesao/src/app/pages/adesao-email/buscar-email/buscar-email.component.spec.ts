import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { BuscarEmailComponent } from './buscar-email.component';

describe('BuscarEmailComponent', () => {
  let component: BuscarEmailComponent;
  let fixture: ComponentFixture<BuscarEmailComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ BuscarEmailComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(BuscarEmailComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
