<?php

namespace Statistics\Calculator\Factory;

use Statistics\Calculator\AbstractCalculator;
use Statistics\Calculator\CalculatorComposite;
use Statistics\Calculator\CalculatorInterface;
use Statistics\Dto\ParamsTo;
use Statistics\Exception\CanNotDetermineCalculatorException;

/**
 * Class StatisticsCalculatorFactory
 *
 * @package Statistics\Calculator
 */
class StatisticsCalculatorFactory
{

    /**
     * @var AbstractCalculator[]
     */
    private $calculators = [];

    /**
     * @param AbstractCalculator[] $calculators
     */
    public function __construct(iterable $calculators)
    {
        foreach ($calculators as $calculator) {
            if (!$calculator instanceof AbstractCalculator) {
                throw CanNotDetermineCalculatorException::invalidCalculator(get_class($calculator));
            }
            $this->calculators[$calculator->getStatisticsType()] = $calculator;
        }
    }

    /**
     * @param ParamsTo[] $parameters
     *
     * @return CalculatorInterface
     */
    public function create(array $parameters): CalculatorInterface
    {
        $calculator = new CalculatorComposite();

        foreach ($parameters as $paramsTo) {
            $statName = $paramsTo->getStatName();
            if (!$paramsTo instanceof ParamsTo
                || !array_key_exists($statName, $this->calculators)
            ) {
                continue;
            }

            $child = $this->calculators[$statName];
            $child->setParameters($paramsTo);

            $calculator->addChild($child);
        }

        return $calculator;
    }
}
