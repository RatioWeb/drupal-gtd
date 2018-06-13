# Quick start guide #

- Add following entries to your `/etc/hosts `file.

``` shell
frontend.headless_drupal.docker.localhost headless_drupal.docker.localhost 127.0.0.1
```

- Now, execute following commands

``` shell
docker-compose up -d
docker-compose exec php /bin/bash
composer install
composer drupal:scaffold
```

Now, you have working Drupal installation. Please visit http://headless_drupal.docker.localhost:8000 and check. You can use `root` for login and `root` for password.
