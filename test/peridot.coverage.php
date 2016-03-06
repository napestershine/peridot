<?php

declare (strict_types = 1); // @codeCoverageIgnore

use Evenement\EventEmitterInterface;
use Peridot\Reporter\CodeCoverage\AbstractCodeCoverageReporter;
use Peridot\Reporter\CodeCoverageReporters;

require __DIR__ . '/../vendor/autoload.php';

return function (EventEmitterInterface $emitter) {
    $configurator = require __DIR__ . '/peridot.php';
    $configurator($emitter);

    (new CodeCoverageReporters($emitter))->register();

    $emitter->on('code-coverage.start', function (AbstractCodeCoverageReporter $reporter) {
        $reporter->addDirectoryToWhitelist(__DIR__ . '/../src');
    });
};
