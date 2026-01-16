# Morizon

## Setup

1. Clone repository

```bash
git clone git@github.com:kgslotwinski/morizon.git

```

2. Build applications from repository

```bash
docker-compose build --no-cache
```

3. Start applications from repository

```bash
docker-compose up -d
```

4. Import user data (ex. with default token and port):

```bash
curl -X POST http://localhost:4000/import \
  -H "Authorization: Bearer jFwFrzUqGJ9oRD0xb96TO8k3ck067f21"
```

5. Access applications (ex. with default ports):

- **Phoenix backend**: http://localhost:4000
- **Symfony frontend**: http://localhost:8000

## Default .env variables

```env
DATABASE_HOST=phoenix-api-db          # PostgreSQL container hostname
DATABASE_PORT=5432                     # PostgreSQL port
DATABASE_NAME=phoenix-api-db-name      # Database name
DATABASE_USER=phoenix-api-db-user      # Database username
DATABASE_PASSWORD=phoenix-api-db-password  # Database password

PHOENIX_API_HOST=phoenix-api          # Phoenix container hostname
PHOENIX_API_PORT=4000                  # Phoenix API port
PHOENIX_API_TOKEN=jFwFrzUqGJ9oRD0xb96TO8k3ck067f21  # API authentication token

SYMFONY_APP_PORT=8000                  # Symfony frontend port
```

## User data import resources

- [Male first names](https://api.dane.gov.pl/resources/63929,lista-imion-meskich-w-rejestrze-pesel-stan-na-22012025-imie-pierwsze/csv)
- [Male last names](https://api.dane.gov.pl/resources/63892,nazwiska-meskie-stan-na-2025-01-22/csv)
- [Female first names](https://api.dane.gov.pl/resources/63924,lista-imion-zenskich-w-rejestrze-pesel-stan-na-22012025-imie-pierwsze/csv)
- [Female last Names](https://api.dane.gov.pl/resources/63888,nazwiska-zenskie-stan-na-2025-01-22/csv)
