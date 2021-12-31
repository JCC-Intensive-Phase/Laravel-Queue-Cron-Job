# Laravel-Queue-Cron-Job
## Nama : Fatimah Ulwiyatul Badriyah

## How to run project
1. git clone
2. cd project
3. composer install
4. php artisan storage:link
5. set env QUEUE_CONNECTION=redis
6. set env REDIS_CLIENT=predis
6. set env BACKUP_DUMP_BINARY_PATH=your dump binary path
7. php artisan migrate --seed
8. php artisan serve
9. php artisan horizon

## Run notify localy
1. Notify expire = php artisan command:notify-expire
2. Notify paid = php artisan command:notify-paid
3. Backup database = php artisan backup:run
