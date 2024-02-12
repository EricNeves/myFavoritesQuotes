FROM node:latest as builder

RUN npm install -g pnpm

WORKDIR /app

COPY package.json ./
COPY pnpm-lock.yaml ./

COPY . .

RUN pnpm install

RUN pnpm run build

FROM nginx:alpine

COPY nginx/nginx.conf /etc/nginx/nginx.conf

COPY --from=builder /app/dist/web/browser /usr/share/nginx/html

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]
