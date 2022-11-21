<?php

namespace Statistics\Calculator;

use SocialPost\Dto\SocialPostTo;
use Statistics\Dto\StatisticsTo;
use Statistics\Enum\StatsEnum;

/**
 * Class LongestPostCalculator
 *
 * @package Statistics\Calculator
 */
class MaxPostLength extends AbstractCalculator
{

    protected const UNITS = 'characters';
    protected const LABEL = 'Longest post by character length in a given month';

    /**
     * @var int
     */
    private $maxPostLength = 0;

    /**
     * @param SocialPostTo $postTo
     */
    protected function doAccumulate(SocialPostTo $postTo): void
    {
        $postLength = strlen($postTo->getText());

        if ($this->maxPostLength < $postLength) {
            $this->maxPostLength = $postLength;
        }
    }

    /**
     * @return StatisticsTo
     */
    protected function doCalculate(): StatisticsTo
    {
        return (new StatisticsTo())->setValue($this->maxPostLength);
    }

    /**
     * @inheritDoc
     */
    public function getStatisticsType(): string
    {
        return StatsEnum::MAX_POST_LENGTH;
    }
}
