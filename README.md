#  Laravel11

Please Insure is docker is install in your system and running

## Project setup
```
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php82-composer:latest \
    composer install --ignore-platform-reqs
    
```

### Build the docker container
```
./vendor/bin/sail build
```

### Start sail to run project
```
./vendor/bin/sail up
```

### Run your unit tests
```
./vendor/bin/pest
```

### Lints and fixes files
```
./vendor/bin/pint
```

### Customize sail configuration and more info
See [Configuration Reference](https://laravel.com/docs/10.x/sail).