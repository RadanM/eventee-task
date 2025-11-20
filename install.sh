#!/bin/sh

cd apps/api

composer install

if [ ! -f .env ]; then
    cp .env.example .env
fi

php artisan jwt:secret
JWT_SECRET=$(grep -v '^#' .env | grep 'JWT_SECRET=' | cut -d '=' -f2-)

cd ../..

cd apps/chat
npm install

cat > local.config.json <<EOL
{
    "auth": {
        "jwtSecret": "$JWT_SECRET"
    }
}
EOL

cd ../..

cd apps/web-app
npm install
cd ../..
