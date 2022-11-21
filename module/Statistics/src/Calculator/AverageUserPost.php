<?php

namespace Statistics\Calculator;

use SocialPost\Dto\SocialPostTo;
use Statistics\Dto\AverageUserPostsStatistic;
use Statistics\Dto\StatisticsTo;
use Statistics\Enum\StatsEnum;

/**
 * Average number of posts per user per month
 *
 * @package Statistics\Calculator
 */
class AverageUserPost extends AbstractCalculator
{

    protected const UNITS = 'posts';
    protected const LABEL = 'Average number of posts per user in a given month';

    /**
     * @var array
     */
    private array $userPosts = [];

    /**
     * @inheritDoc
     */
    protected function doAccumulate(SocialPostTo $postTo): void
    {
        $this->userPosts[$postTo->getAuthorId()] = ($this->userPosts[$postTo->getAuthorId()] ?? 0) + 1;
    }

    /**
     * @inheritDoc
     */
    protected function doCalculate(): StatisticsTo
    {
        $stats = new StatisticsTo();
        foreach ($this->userPosts as $userId => $totalPosts) {
            $child = (new AverageUserPostsStatistic())
                ->setName($this->parameters->getStatName())
                ->setValue($totalPosts)
                ->setUserId($userId)
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
        return StatsEnum::AVERAGE_POST_NUMBER_PER_USER;
    }
}
