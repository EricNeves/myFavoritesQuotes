import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';

import { environment } from '../../environments/environment.development';

import { Quote } from '../models/quote.model';
import { HttpClient } from '@angular/common/http';

@Injectable({
  providedIn: 'root'
})
export class QuoteService {

  constructor(private http: HttpClient) { }

  public fetchRandomQuote(): Observable<Quote<any>> {
    return this.http.get<Quote<any>>(`${environment.api}/quotes/fetch`)
  }

  public getQuotes(page: number|string): Observable<Quote<any>> {
    return this.http.get<Quote<any>>(`${environment.api}/quotes/all?page=${page}`)
  }

  public getQuoteById(id: number|string): Observable<Quote<any>> {
    return this.http.get<Quote<any>>(`${environment.api}/quotes/${id}/fetch`)
  }

  public createQuote(quote: Quote<any>): Observable<Quote<any>> {
    return this.http.post<Quote<any>>(`${environment.api}/quotes/create`, quote)
  }

  public deleteQuote(id: number|string): Observable<any> {
    return this.http.delete<any>(`${environment.api}/quotes/${id}/delete`)
  }

  public updateQuote(id: any, quote: Quote<any>): Observable<Quote<any>> {
    return this.http.put<Quote<any>>(`${environment.api}/quotes/${id}/update`, quote)
  }
}
