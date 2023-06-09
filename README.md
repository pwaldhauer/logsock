# logsock


![Logo](public/img/cat-small.png)

A really simple web app to log stuff and send notifications. 
It uses the [Web Push API](https://developer.mozilla.org/en-US/docs/Web/API/Push_API) to send notifications to your phone or desktop browser.

Example use cases:

- Notify yourself after a long running task has finished
- Receive alerts from monitoring tools

![Screenshot](logsock-screenshot.png)

## Setup

- Generate a VAPID keypair

```

# using the web-push nodejs package
npx web-push generate-vapid-keys

# using openssl
openssl ecparam -genkey -name prime256v1 -out private_key.pem
echo VAPID_PUBLIC_KEY=$(openssl ec -in private_key.pem -pubout -outform DER|tail -c 65|base64|tr -d '=' |tr '/+' '_-')
echo VAPID_PRIVATE_KEY=$(openssl ec -in private_key.pem -outform DER|tail -c +8|head -c 32|base64|tr -d '=' |tr '/+' '_-')

```

- Use a docker-compose file like the following:

```
---
version: '3'
services:
  logsock:
    image: ghcr.io/pwaldhauer/logsock:latest
    ports:
      - "127.0.0.1:9901:9901"
    environment:
      - TRUST_PROXIES="*"
      - APP_URL="https://logsock.example.com"
      - VAPID_SUBJECT="mailto:foo@example.com"
      - VAPID_PRIVATE_KEY="xxx"
      - VAPID_PUBLIC_KEY="xxx"
    volumes:
      - logsock-data:/app/storage
    restart: always

volumes:
  logsock-data:

```

- Of course, you could also install it without docker, it should work on any PHP 8.2+ installations:

```
npm run build
composer install
cp .env.example .env

# Put your VAPID keys in the .env file

php artisan key:generate
php artisan app:init
```

- Put it behind a reverse proxy with SSL
- Create a user:


```

docker compose exec logsock php artisan app:user-create

# or, if not using docker

php artisan app:user-create

```

- Add the page to your home screen (on iOS), go to the settings (cog wheel) and click _Subscribe_ to subscribe for notifications
- On the same page, create your API token and send your first log:

```

curl "https://logsock.example.com/api/?_token=YOUR-API-TOKEN&topic=test&message=Hello%20World"

```

## License

MIT
