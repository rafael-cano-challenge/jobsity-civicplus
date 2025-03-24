#!/bin/sh

cp -r /usr/src/cache/node_modules/. /var/www/workspace/node_modules/

#rm -rf /var/www/workspace/node_modules/.package-lock.json

if [ "$TARGET" = "prod" ]; then
  exec npm run build
else
  exec npm run dev
fi
