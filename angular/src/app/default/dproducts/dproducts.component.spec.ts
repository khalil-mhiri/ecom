import { ComponentFixture, TestBed } from '@angular/core/testing';

import { DproductsComponent } from './dproducts.component';

describe('DproductsComponent', () => {
  let component: DproductsComponent;
  let fixture: ComponentFixture<DproductsComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [DproductsComponent]
    })
    .compileComponents();

    fixture = TestBed.createComponent(DproductsComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
