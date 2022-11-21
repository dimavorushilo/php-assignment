<?php

namespace Statistics\Exception;

use RuntimeException;
use Statistics\Calculator\AbstractCalculator;

class CanNotDetermineCalculatorException extends RuntimeException
{

    public static function invalidCalculator(string $className): self
    {
        return new self(sprintf('Calculator must extend %s. Given: %s', AbstractCalculator::class, $className));
    }
}