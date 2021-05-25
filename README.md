# symfony-share-video-app


## DB commands
### Quick tear down and put db up
php bin/console doctrine:schema:drop -n -q --force --full-database  
__[Delete migrations versions from the migrations file]__  
php bin/console make:migration  
php bin/console doctrine:migrations:migrate -n -q  
php bin/console doctrine:fixtures:load -n -q
