import { Injectable } from '@angular/core';
import { HttpService } from "src/app/http.service";

@Injectable()
export class GreenModel {
	constructor(private httpService: HttpService){}
	
	getAll() {
		return this.httpService.sendGetRequest("/green")
	}
	
	deleteById(id: number){
		var path: string = "/green/" + id + "/delete"
		return this.httpService.sendPostRequest( path, {})
	}
	
	updateById(id: string, green: any) {
		var path: string = "/green/" + id + "/update"
		return this.httpService.sendPostRequest( path, green)
	}
	
	addGreen(green: any) {
		var path: string = "/green/"
		return this.httpService.sendPostRequest( path, green)
	}
}