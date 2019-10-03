<?php

if (isset($_ENV['BOOTSTRAP_CLEAR_CACHE'])) {
    passthru(sprintf(
        'php "%s/../bin/console" cache:clear --no-warmup --env=%s',
        __DIR__,
        $_ENV['BOOTSTRAP_CLEAR_CACHE']
    ));
}

if (isset($_ENV['BOOTSTRAP_DATABASE_CREATE'])) {
    passthru(sprintf(
        'php "%s/../bin/console" doctrine:database:drop --force --quiet --env=%s',
        __DIR__,
        $_ENV['BOOTSTRAP_DATABASE_CREATE']
    ));

    passthru(sprintf(
        'php "%s/../bin/console" doctrine:database:create --quiet --if-not-exists --env=%s',
        __DIR__,
        $_ENV['BOOTSTRAP_DATABASE_CREATE']
    ));

    passthru(sprintf(
        'php "%s/../bin/console" doctrine:schema:create  --quiet --no-interaction --env=%s',
        __DIR__,
        $_ENV['BOOTSTRAP_DATABASE_CREATE']
    ));

    passthru(sprintf(
        'php "%s/../bin/console" doctrine:schema:update --force --no-interaction --quiet --env=%s',
        __DIR__,
        $_ENV['BOOTSTRAP_DATABASE_CREATE']
    ));
}

if (isset($_ENV['BOOTSTRAP_DATABASE_FIXTURES'])) {
    passthru(sprintf(
        'php "%s/../bin/console" doctrine:fixture:load --no-interaction --env=%s',
        __DIR__,
        $_ENV['BOOTSTRAP_DATABASE_FIXTURES']
    ));
}

require __DIR__ . '/../config/bootstrap.php';