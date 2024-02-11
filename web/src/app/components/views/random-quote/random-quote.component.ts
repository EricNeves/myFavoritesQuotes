import { Component, OnInit } from '@angular/core';
import { Quote } from '../../../models/quote.model';
import { QuoteService } from '../../../services/quote.service';
import { UserService } from '../../../services/user.service';
import { User } from '../../../models/user.model';

@Component({
  selector: 'app-random-quote',
  templateUrl: './random-quote.component.html',
  styleUrl: './random-quote.component.css'
})
export class RandomQuoteComponent implements OnInit {
  public quote: Quote<any>   = {}
  public message: any        = null
  public firstLetter: any    = ''
  public loading: boolean    = false

  constructor(private quoteService: QuoteService, private userService: UserService) { }

  private loadRandomQuoteWithUser() {
    this.loading = true

    this.quoteService.fetchRandomQuote().subscribe({
      next: (response: any) => {
        this.quote = response.data

        this.firstLetter = this.quote.username?.charAt(0).toUpperCase()

        this.loading = false
      },
      error: (error: any) => {
        this.message = error.error.message
      }
    })
  }

  ngOnInit() {
    this.loadRandomQuoteWithUser()
  }

  public load() {
    this.loadRandomQuoteWithUser()
  }
}
