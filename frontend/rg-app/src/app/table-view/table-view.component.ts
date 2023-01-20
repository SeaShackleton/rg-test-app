import { Component, OnInit, OnDestroy, ChangeDetectionStrategy   } from '@angular/core';
import { CommonModule } from '@angular/common'
import { HttpService } from "src/app/http.service"
import { GreenModel } from "src/app/model/green"
import { MatTableModule, MatTableDataSource  } from "@angular/material/table"
import { Subscription } from 'rxjs'
import { ChildFormComponent } from "src/app/table-view/child-form.component"

interface GreenElement {
  id: string;
  name: string;
  state: string;
  zip: string;
  amount: string;
  qty: string;
  item: string;
} 

@Component({
  selector: 'app-table-view',
  standalone: true,
  imports: [CommonModule, MatTableModule, ChildFormComponent],
  templateUrl: './table-view.component.html',
  styleUrls: ['./table-view.component.scss'],
  changeDetection: ChangeDetectionStrategy.OnPush
})
export class TableViewComponent implements OnInit, OnDestroy {
	
	dataSource:any = new MatTableDataSource<GreenElement>()
	greenSubscription = new  Subscription()	
	displayedColumns: string[] = ['id', 'name', 'state', 'zip', 'amount', 'qty', 'item', 'controlColmn']

	constructor(private httpService: HttpService, private green: GreenModel) {} 
	
	ngOnInit(): void {
		this.greenSubscription = this.green.getAll().subscribe((res: any) => {
			this.dataSource.data = res
			this.greenSubscription.unsubscribe()
		})
	}

	ngOnDestroy(): void {
		// if the subscription is not closed -> close it
		if( !this.greenSubscription.closed ) this.greenSubscription.unsubscribe()
	}

	addGreen(green: any) {
		console.log("add green ");
		console.log(green);
		this.greenSubscription = this.green.addGreen( green ).subscribe((res: any) => {
			this.dataSource.data = res
			this.greenSubscription.unsubscribe()
		});
	}
	
	deleteGreen(id: number) {
		this.greenSubscription = this.green.deleteById(id).subscribe((res: any) => {
			this.dataSource.data = res
			this.greenSubscription.unsubscribe()
		})
	}
	
	changeGreen(e: any, id: string, pos: number) {
		console.log("Change green with ID:  " + id + " with new data: " + e.target.value);
		//console.log(e);
		
		for(var i = 0; i < this.dataSource.data.length; i++){
			if( this.dataSource.data[i].id == id ){
				var green = this.dataSource.data[i];
				console.log("moving from:");
				console.log(green);
				switch(pos) { 
				   case 1: { 
				      //change name	
					  green.name = e.target.value
					  break; 
				   }
				   case 2: { 
				      //change state	
					  green.state = e.target.value
					  break; 
				   } 
				   case 3: { 
				      //change zip	
					  green.zip = e.target.value
					  break; 
				   } 
				   case 4: { 
				      //change amount	
					  green.amount = e.target.value
					  break; 
				   } 
				   case 5: { 
				      //change qty	
					  green.qty = e.target.value
					  break; 
				   } 
				   case 6: { 
				      //change item	
					  green.item = e.target.value
					  break; 
				   }  
				} 				
				
				this.greenSubscription = this.green.updateById(id, green).subscribe((res: any) => {
					this.dataSource.data = res
					this.greenSubscription.unsubscribe()
				})				
			}
		}
	}
}
