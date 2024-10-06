php artisan route:list
php artisan config:cache
php artisan make:resource CustomerCollection --collection
php artisan make:resource CustomerResource
php artisan make:controller DemoRegistrationController --resource
php artisan make:model DemoRegistration


php artisan make:factory CustomerFactory -model=Customer
php artisan make:seeder CustomerSeeder

php artisan config:clear
php artisan config:cache
 env(SUGAR_DADDY)

 Tao seeder
 php artisan make:seeder CustomerSeeder    
 sau do run seeder
 php artisan db:seed --class=CustomerSeeder


 Response Codes
200 OK

304 Not Modified

400 Bad Request

401 Not Authorized

404 Data not found

500 Internal server error

git push origin master --force