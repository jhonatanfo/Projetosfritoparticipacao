import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { VincularChaveComponent } from './vincular-chave.component';

describe('VincularChaveComponent', () => {
  let component: VincularChaveComponent;
  let fixture: ComponentFixture<VincularChaveComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ VincularChaveComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(VincularChaveComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
