
RM = rm -rf
CHMOD = chmod
PHPCS = vendor/bin/phpcs
PHPCS_STANDARD = vendor/thefox/phpcsrs/Standards/TheFox
PHPCS_REPORT = --report=full --report-width=160
PHPUNIT = vendor/bin/phpunit
COMPOSER = ./composer.phar
COMPOSER_DEV ?= --dev


.PHONY: all install update test test_phpcs test_phpunit test_phpunit_cc clean

all: install test

install: $(COMPOSER)
	$(COMPOSER) install $(COMPOSER_PREFER_SOURCE) --no-interaction $(COMPOSER_DEV)

update: $(COMPOSER)
	$(COMPOSER) selfupdate
	$(COMPOSER) update

$(COMPOSER):
	curl -sS https://getcomposer.org/installer | php
	$(CHMOD) 755 $(COMPOSER)

$(PHPCS): $(COMPOSER)

test: test_phpcs test_phpunit

test_phpcs: $(PHPCS) vendor/thefox/phpcsrs/Standards/TheFox
	$(PHPCS) -v -s $(PHPCS_REPORT) --standard=$(PHPCS_STANDARD) src tests

test_phpunit: $(PHPUNIT) phpunit.xml
	$(PHPUNIT) $(PHPUNIT_COVERAGE_HTML) $(PHPUNIT_COVERAGE_CLOVER)

test_phpunit_cc: build
	$(MAKE) test_phpunit PHPUNIT_COVERAGE_HTML="--coverage-html build/report"

build:
	$(MKDIR) build
	$(MKDIR) build/logs
	$(CHMOD) 0700 build

clean:
	$(RM) composer.lock $(COMPOSER)
	$(RM) vendor/*
	$(RM) vendor
