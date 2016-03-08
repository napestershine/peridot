<?php

declare (strict_types = 1); // @codeCoverageIgnore

namespace Recoil\Peridot;

use Evenement\EventEmitterInterface;
use Peridot\Core\AbstractTest;
use Peridot\Core\Suite;
use Recoil\React\ReactKernel;
use ReflectionClass;

final class RecoilTestExecutor
{
    /**
     * @codeCoverageIgnore
     */
    public function __construct(callable $next = null)
    {
        $this->next = $next;
    }

    /**
     * @codeCoverageIgnore
     */
    public function __invoke(EventEmitterInterface $emitter)
    {
        $emitter->on(
            'suite.start',
            function ($suite) {
                $this->wrapSuite($suite);
            }
        );

        if ($this->next) {
            ($this->next)($emitter);
        }
    }

    private function wrapSuite(Suite $suite)
    {
        $reflector = new ReflectionClass(AbstractTest::class);

        $this->definition = $reflector->getProperty('definition');
        $this->definition->setAccessible(true);

        $this->setUpFns = $reflector->getProperty('setUpFns');
        $this->setUpFns->setAccessible(true);

        $this->tearDownFns = $reflector->getProperty('tearDownFns');
        $this->tearDownFns->setAccessible(true);

        foreach ($suite->getTests() as $test) {
            if ($test instanceof AbstractTest) {
                $this->wrapTest($test);
            }
        }
    }

    private function wrapTest(AbstractTest $test)
    {
        $this->definition->setValue(
            $test,
            $this->wrapFunction(
                $this->definition->getValue($test)
            )
        );

        $this->setUpFns->setValue(
            $test,
            array_map(
                function (callable $fn) {
                    return $this->wrapFunction($fn);
                },
                $this->setUpFns->getValue($test)
            )

        );

        $this->tearDownFns->setValue(
            $test,
            array_map(
                function (callable $fn) {
                    return $this->wrapFunction($fn);
                },
                $this->tearDownFns->getValue($test)
            )
        );
    }

    private function wrapFunction(callable $fn)
    {
        return function (...$arguments) use ($fn) {
            $result = $fn(...$arguments);

            if ($result !== null) {
                ReactKernel::start($result);
            }
        };
    }

    private $next;
    private $definition;
    private $setUpFns;
    private $tearDownFns;
}
