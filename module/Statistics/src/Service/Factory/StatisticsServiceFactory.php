<?php

namespace Statistics\Service\Factory;

use Statistics\Calculator\AveragePostLength;
use Statistics\Calculator\AverageUserPost;
use Statistics\Calculator\Factory\StatisticsCalculatorFactory;
use Statistics\Calculator\MaxPostLength;
use Statistics\Calculator\TotalPostsPerWeek;
use Statistics\Service\StatisticsService;

/**
 * Class StatisticsServiceFactory
 *
 * @package Statistics\Service\Factory
 */
class StatisticsServiceFactory
{

    /**
     * @return StatisticsService
     */
    public static function create(): StatisticsService
    {
        $calculators = [
            new AveragePostLength(),
            new MaxPostLength(),
            new TotalPostsPerWeek(),
            new AverageUserPost(),
        ];
        $calculatorFactory = new StatisticsCalculatorFactory($calculators);

        return new StatisticsService($calculatorFactory);
    }
}
