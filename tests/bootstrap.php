<?php

use Symfony\Component\Dotenv\Dotenv;

require dirname(__DIR__).'/vendor/autoload.php';

(new Dotenv())->bootEnv(dirname(__DIR__).'/.env');

if ($_SERVER['APP_DEBUG']) {
    umask(0000);
}

passthru('php bin/console doctrine:database:drop --if-exists --force --env=test');
passthru('php bin/console doctrine:database:create --if-not-exists --env=test');
passthru('php bin/console doctrine:migrations:migrate --no-interaction --env=test');
