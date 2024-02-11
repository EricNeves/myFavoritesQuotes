import { CanActivateFn, Router } from '@angular/router';

import { JwtService } from './services/jwt.service';
import { inject } from '@angular/core';

export const authGuard: CanActivateFn = (route, state) => {
  const jwtService = inject(JwtService);
  const router     = inject(Router);

  const token = jwtService.getToken();

  if (!token) {
    router.navigate(['/login']);
    return false;
  }

  return true;
};
