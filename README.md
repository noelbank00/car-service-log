## Generate a self-signed certificate for local development (execute in ./docker/nginx/ssl directory)

```bash
openssl req -x509 -out car-service-log.develop.crt -keyout car-service-log.develop.key \
        -newkey rsa:2048 -nodes -sha256 \
        -subj '/CN=car-service-log.develop' -extensions EXT -config config.conf \
	    -days 365
```

## Add the certificate to your system's trusted certificates (Only for macOS)

```bash
sudo security add-trusted-cert -d -r trustRoot -k /Library/Keychains/System.keychain car-service-log.develop.crt
```

## Add the domain to your hosts file

```bash
127.0.0.1   car-service-log.develop 
```

## Start the Docker containers

```bash
docker compose up -d
```

## Run the database migrations

```bash
docker compose exec app php artisan migrate
```

## Access the application

Open your browser and navigate to [https://car-service-log.develop](https://car-service-log.develop).

## Worktime

| Duration   | Description                                         |
|------------|-----------------------------------------------------|
| 42 mins    | Add docker                                          |
| ~5 mins    | Cleanup code (AI)                                   |
| ~3 hours   | Add tables                                          |
| ~1 hours   | Add search                                          |
| 20 mins    | Refactor code (AI)                                  |
| ---------- | --------------------------------------------------- |