test: install
	vendor/bin/peridot test/suite -c test/peridot.php

coverage: install
	phpdbg -qrr vendor/bin/peridot test/suite -c test/peridot.coverage.php \
		--reporter spec \
		--reporter html-code-coverage --code-coverage-path=artifacts/tests/coverage

lint: install
	./vendor/bin/php-cs-fixer fix

install: vendor/autoload.php

prepare: lint coverage

ci:
	phpdbg -qrr vendor/bin/peridot test/suite -c test/peridot.coverage.php \
		--reporter spec \
		--reporter clover-code-coverage --code-coverage-path=artifacts/tests/coverage/clover.xml

.PHONY: _default test coverage lint install prepare ci

vendor/autoload.php: composer.lock
	composer install

composer.lock: composer.json
	composer update
