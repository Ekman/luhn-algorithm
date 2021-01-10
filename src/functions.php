<?php

namespace Nekman\LuhnAlgorithm\Functions;

/**
 * Determine if a string consists of only numbers
 * @param string $possibleNumber The number to check
 * @return bool true if the number consists only of numbers, false otherwise
 * @internal
 */
function string_is_numeric(string $possibleNumber): bool
{
    return preg_match("/^\d+(\.\d+)?$/", $possibleNumber);
}
