# Build docker containers
docker compose up -d --build

# Create database
docker exec -it mysql bash -c 'mysql -uroot -phuyFTYt12_ -e "create database 'test'"'

# Install laravel and create project
docker exec -it php bash -c ' \
composer create-project laravel/laravel /var/www/test ; \
php /var/www/test/artisan install:api ; \
cp -a ./source/. /var/www/test/ ; \
php /var/www/test/artisan migrate ; \
php /var/www/test/artisan optimize'
