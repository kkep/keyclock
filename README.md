# Setup

## 1. Clone repository
``
git clone https://github.com/kkep/keycloak.git
``

## 2. Run Docker Engine

## 3. Create .env file on /app

## 4. Add rows to HOSTS file
```
127.0.0.1 auth.alabuga-start.ru
127.0.0.1 portal.alabuga-start.ru
```

## 5. Run commands
````
docker-compose up --build
docker exec -it portal php artisan migrate
````



# Keycloak Admin
```
Login: admin
Password: admin
```
