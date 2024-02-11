export interface Quote<T> {
  author?: string;
  quote?: string;
  id?: number|string;
  quotes?: [
    {
      id?: number;
      quote?: string;
      author?: string;
      created_at?: Date;
      updated_at?: Date;
      userId?: number;
    }
  ];
  [key: string]: any;
}
