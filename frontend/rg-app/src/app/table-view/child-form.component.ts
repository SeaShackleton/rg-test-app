import { Component, EventEmitter, Output } from '@angular/core';
import { FormBuilder, FormControl, FormGroup, ReactiveFormsModule } from '@angular/forms';

@Component({
  selector: 'app-child-form',
  standalone: true,
  imports: [ReactiveFormsModule],
  templateUrl: './child-form.component.html',
  styleUrls: ['./child-form.component.scss']
})
export class ChildFormComponent {
	@Output("addGreen") addGreen: EventEmitter<any> = new EventEmitter();

	newGreenForm = this.fb.group({
		name: [''],
		state: [''],
		zip: [''],
		amount: [''],
		qty: [''],
		item: ['']
	})
  
	constructor(private fb: FormBuilder ){}
	
	onSubmit(): void {
		this.addGreen.emit(this.newGreenForm.value);
		this.newGreenForm.reset();
	}
}
