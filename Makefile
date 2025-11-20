.PHONY: api chat web all
api:
	cd apps/api && php artisan serve
databases:
	cd database && docker-compose up -d --build
chat:
	cd apps/chat && node index.js
web:
	cd apps/web-app && yarn run dev
