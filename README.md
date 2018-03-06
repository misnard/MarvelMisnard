## To initialize project

Add you api key in src/Model/MarvelApiClientModel.php

#### Without docker :

Setup project :
```
php composer.phar install

```
Phpunit test :
```
php vendor/phpunit/bin
```
Finally go to your local address.

#### With docker :
```
docker-compose up
```

To get container address :
###### $folderName = MarvelMisnard or folder where you clone the repository
```
docker inspect $folderName_web_1 | grep IPAddress
```

Setup composer project :
```
docker exec -it $folderName_web_1 bash

php composer.phar install
```

To run phpunit tests :
```
docker exec -it $folderName_web_1 bash

php vendor/phpunit/bin
```

Finally go to the container ip to visit project

Maher ISNARD.
maher.isnard@gmail.com
