export interface User<T> {
  id?: number;
  username?: string;
  email?: string;
  password?: string;
  createdAt?: Date;
  updatedAt?: Date;
  [key: string]: any;
}
