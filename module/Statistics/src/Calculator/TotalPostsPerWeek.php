<?php

namespace Statistics\Calculator;

use SocialPost\Dto\SocialPostTo;
use Statistics\Dto\StatisticsTo;
use Statistics\Dto\TotalPostsPerWeekStatistic;
use Statistics\Enum\StatsEnum;

/**
 * Class TotalPosts
 *
 * @package Statistics\Calculator
 */
class TotalPostsPerWeek extends AbstractCalculator
{

    protected const UNITS = 'posts';
    protected const LABEL = 'Total posts split by week';

    /**
     * @var array
     */
    private $totals = [];

    /**
     * @param SocialPostTo $postTo
     */
    protected function doAccumulate(SocialPostTo $postTo): void
    {
        $key = $postTo->getDate()->format('\W\e\e\k W, Y');

        $this->totals[$key] = ($this->totals[$key] ?? 0) + 1;
    }

    /**
     * @return StatisticsTo
     */
    protected function doCalculate(): StatisticsTo
    {
        $stats = new StatisticsTo();
        foreach ($this->totals as $splitPeriod => $total) {
            $child = (new TotalPostsPerWeekStatistic())
                ->setName($this->parameters->getStatName())
                ->setSplitPeriod($splitPeriod)
                ->setValue($total)
                ->setUnits(self::UNITS);

            $stats->addChild($child);
        }

        return $stats;
    }

    /**
     * @inheritDoc
     */
    public function getStatisticsType(): string
    {
        return StatsEnum::TOTAL_POSTS_PER_WEEK;
    }
}
