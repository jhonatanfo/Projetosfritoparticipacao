import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { VincularChaveEmailComponent } from './vincular-chave-email.component';

describe('VincularChaveEmailComponent', () => {
  let component: VincularChaveEmailComponent;
  let fixture: ComponentFixture<VincularChaveEmailComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ VincularChaveEmailComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(VincularChaveEmailComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
