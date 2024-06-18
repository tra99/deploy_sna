// ==========================================================>> Core Library
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Injectable } from '@angular/core';

// ==========================================================>> Custom Library
import { environment as env } from 'environments/environment';

@Injectable({
    providedIn: 'root',
})
export class DashboardService {

    //===> Private Variables used in this file only
    private _apiUrl = env.apiUrl;
    
    constructor(

       //===> Private Variables used in this file only
        private _http: HttpClient
    ){

    }

    getDashboardInfo(): any {

        return this._http.get(this._apiUrl + '/admin/dashboard', {
            headers: new HttpHeaders().set('Content-Type', 'application/json'),
        });

    }
}
