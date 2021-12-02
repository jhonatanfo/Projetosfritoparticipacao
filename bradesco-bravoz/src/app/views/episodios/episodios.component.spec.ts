import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { EpisodiosComponent } from './episodios.component';

describe('EpisodiosComponent', () => {
  let component: EpisodiosComponent;
  let fixture: ComponentFixture<EpisodiosComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ EpisodiosComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(EpisodiosComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
