<?php

namespace Statistics\Dto;

/**
 * Total posts per week statistic DTO
 *
 * @package Statistics\Dto
 */
class TotalPostsPerWeekStatistic extends StatisticsTo
{

    /**
     * @var string
     */
    private $splitPeriod;

    /**
     * @return string|null
     */
    public function getSplitPeriod(): ?string
    {
        return $this->splitPeriod;
    }

    /**
     * @param string $splitPeriod
     *
     * @return $this
     */
    public function setSplitPeriod(string $splitPeriod): self
    {
        $this->splitPeriod = $splitPeriod;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return array_merge(parent::toArray(), [
            'splitPeriod' => $this->getSplitPeriod(),
        ]);
    }
}