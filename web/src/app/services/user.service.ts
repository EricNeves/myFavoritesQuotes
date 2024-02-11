import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs'

import { User } from '../models/user.model';

import { environment } from '../../environments/environment.development'

@Injectable({
  providedIn: 'root'
})
export class UserService {
  constructor(private http: HttpClient) { }

  public register(user: User<string>):Observable<User<string>> {
    return this.http.post<User<string>>(`${environment.api}/users/create`, user);
  }

  public login(user: User<string>):Observable<User<string>> {
    return this.http.post<User<string>>(`${environment.api}/users/auth`, user);
  }

  public getUser():Observable<User<string>> {
    return this.http.get<User<string>>(`${environment.api}/users/fetch`);
  }
}
