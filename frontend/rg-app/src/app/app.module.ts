import { NgModule } from '@angular/core';
import { HttpClientModule, HttpClient } from '@angular/common/http';
import { BrowserModule } from '@angular/platform-browser';
import { MatTableModule } from "@angular/material/table";
import { GreenModel } from "src/app/model/green"

import { HttpService } from './http.service';

import { AppComponent } from './app.component';
import { TableViewComponent } from './table-view/table-view.component';
import { ChildFormComponent } from './table-view/child-form.component';

@NgModule({
  declarations: [
    AppComponent
  ],
  imports: [
    BrowserModule,
	HttpClientModule,
	TableViewComponent,
	ChildFormComponent,
	MatTableModule
  ],
  providers: [
	HttpService,
	GreenModel
  ],
  bootstrap: [AppComponent]
})
export class AppModule { }
