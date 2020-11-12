# FoodAtHome  
Projeto de DAD 2020/21  

## Objective
The main objective of this project is to implement a Single Page Application (SPA), using Vue.js framework    
for the company "Food@Home" (fictitious company) that makes and delivers meals to their customers' homes.  

## default credentials database
User: ``root`` || ``homestead``   
Pass: ``secret``  

## Start-up  
Make your own .env based on .env-example.  
run the following:  
``composer install``  
``npm install``  
``npm run watch``  
After this:
``php artisan migrate``
``php artisan db:seed``
If there is an error, run:
``composer dump-autoload``
``php artisan db:seed``
