## Generate a self-signed certificate for local development (execute in ./docker/nginx/ssl directory)

```bash
openssl req -x509 -out car-service-log.develop.crt -keyout car-service-log.develop.key \
        -newkey rsa:2048 -nodes -sha256 \
        -subj '/CN=car-service-log.develop' -extensions EXT -config config.conf \
	    -days 365
```

## Add the certificate to your system's trusted certificates

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
docker compose exec php php artisan migrate
```

## Access the application

Open your browser and navigate to [https://car-service-log.develop](https://car-service-log.develop).

## Worktime

| Duration   | Description                                         |
|------------|-----------------------------------------------------|
| 42 min     | Add docker                                          |
| 5 min      | Cleanup code (AI)                                   |
| 4          | Developed car service log features                  |
| 2          | Created Docker setup and Nginx configuration        |
| ---------- | --------------------------------------------------- |