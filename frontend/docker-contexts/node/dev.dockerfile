FROM node:20.11.1 AS base

WORKDIR /usr/src/cache

COPY --from=root package*.json ./

RUN npm install

WORKDIR /var/www/workspace

COPY --from=root . .

FROM base AS dev
ENV TARGET dev

FROM base AS prod
ENV TARGET prod