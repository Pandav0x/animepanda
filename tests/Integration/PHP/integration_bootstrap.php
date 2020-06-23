<?php

if (isset($_ENV['BOOTSTRAP_DATABASE_CREATION'])) {
    passthru(
        sprintf(
            'php "%s/../../../bin/console" doctrine:database:drop --force --quiet --env=%s',
            __DIR__,
            $_ENV['BOOTSTRAP_DATABASE_CREATION']
        )
    );

    passthru(
        sprintf(
            'php "%s/../../../bin/console" doctrine:database:create --quiet --if-not-exists --env=%s',
            __DIR__,
            $_ENV['BOOTSTRAP_DATABASE_CREATION']
        )
    );

    passthru(
        sprintf(
            'php "%s/../../../bin/console" doctrine:schema:create  --quiet --no-interaction --env=%s',
            __DIR__,
            $_ENV['BOOTSTRAP_DATABASE_CREATION']
        )
    );

    passthru(
        sprintf(
            'php "%s/../../../bin/console" doctrine:schema:update --force --no-interaction --quiet --env=%s',
            __DIR__,
            $_ENV['BOOTSTRAP_DATABASE_CREATION']
        )
    );
}

if (isset($_ENV['BOOTSTRAP_DATABASE_FIXTURES'])) {
    passthru(
        sprintf(
            'php "%s/../../../bin/console" doctrine:fixture:load --no-interaction --env=%s',
            __DIR__,
            $_ENV['BOOTSTRAP_DATABASE_FIXTURES']
        )
    );
}
