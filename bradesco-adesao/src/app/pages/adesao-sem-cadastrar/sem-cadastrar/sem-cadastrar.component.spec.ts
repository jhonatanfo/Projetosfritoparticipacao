import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { SemCadastrarComponent } from './sem-cadastrar.component';

describe('SemCadastrarComponent', () => {
  let component: SemCadastrarComponent;
  let fixture: ComponentFixture<SemCadastrarComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ SemCadastrarComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(SemCadastrarComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
