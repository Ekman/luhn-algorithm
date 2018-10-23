#!/bin/bash

#
# Runs code standard fixer without having the need to specify it as a
# Composer dependency.
#

composer require --no-interaction friendsofphp/php-cs-fixer:^2.0

vendor/bin/php-cs-fixer --config=.php_cs.dist --no-interaction fix

composer remove --no-interaction friendsofphp/php-cs-fixer
