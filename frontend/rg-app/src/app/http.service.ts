import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
import { environment } from './../environments/environment';

@Injectable({
  providedIn: 'root'
})
export class HttpService {

  apiUrl = environment.apiUrl+":8000";
  
  constructor(private httpClient: HttpClient) { }
  
   sendGetRequest(path: string) {
    return this.httpClient.get(this.apiUrl + path);
  }
  
  sendPostRequest(path: string, data: Object): Observable<Object> {
    return this.httpClient.post(this.apiUrl + path, data, {headers: {"Content-Type":"application/json"}});
  }
}
