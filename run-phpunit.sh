#!/bin/bash

#
# Runs code standard fixer without having the need to specify it as a
# Composer dependency.
#

if [ $TRAVIS == true ]; then
    # No need to install PHPunit
    phpunit --configuration phpunit.xml
else
    composer require --no-interaction phpunit/phpunit:^6.0

    vendor/bin/phpunit --configuration phpunit.xml

    composer remove --no-interaction phpunit/phpunit
fi;