FROM nginx:alpine

ADD site.conf /etc/nginx/conf.d/default.conf
ADD nginx.conf /etc/nginx/nginx.conf

RUN mkdir -p /var/www/workspace