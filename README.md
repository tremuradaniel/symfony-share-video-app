# symfony-share-video-app


## DB commands
### Quick tear down and put db up
php bin/console doctrine:schema:drop -n -q --force --full-database  
__[Delete migrations versions from the migrations file]__  
php bin/console make:migration  
php bin/console doctrine:migrations:migrate -n -q  
php bin/console doctrine:fixtures:load -n -q

## Functional Testing

__run all tests__ ``` php ./bin/phpunit ```
__run certain tests__ ``` php ./bin/phpunit --filter 'Tests\\Front' ```
__run certain test__ ``` php ./bin/phpunit --filter 'Tests\\FrontControllerVideoTest::testNoResults' ```
