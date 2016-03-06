<?php

declare (strict_types = 1); // @codeCoverageIgnore

namespace Recoil\Peridot;

use Recoil\Recoil;

describe(Configurator::class, function () {

    describe('peridot functions as coroutines', function () {

        beforeEach(function () {
            yield Recoil::sleep(0.01);
            $this->beforeEachRan = true;
        });

        it('coroutine based test', function () {
            yield Recoil::sleep(0.01);
            $this->testRan = true;
        });

        afterEach(function () {
            yield Recoil::sleep(0.01);
            $this->afterEach = true;
        });

    });

    it('runs all functions as coroutines', function () {
        expect($this->beforeEachRan)->to->be->true;
        expect($this->testRan)->to->be->true;
        expect($this->afterEach)->to->be->true;
    });
});
