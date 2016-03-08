<?php

declare (strict_types = 1); // @codeCoverageIgnore

use Evenement\EventEmitterInterface;
use Peridot\Console\Environment;
use Recoil\Peridot\RecoilTestExecutor;

require __DIR__ . '/vendor/autoload.php';

return new RecoilTestExecutor(
    function (EventEmitterInterface $emitter) {
        $emitter->on('peridot.start', function (Environment $environment) {
            $environment->getDefinition()->getArgument('path')->setDefault('test/suite');
        });
    }
);
