<?php

namespace Statistics\Dto;

/**
 * Average user post statistic DTO
 *
 * @package Statistics\Dto
 */
class AverageUserPostsStatistic extends StatisticsTo
{

    /**
     * @var string
     */
    private string $userId;

    /**
     * @return string
     */
    public function getUserId(): string
    {
        return $this->userId;
    }

    /**
     * @param string $userId
     *
     * @return $this
     */
    public function setUserId(string $userId): self
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return array_merge(parent::toArray(), [
            'userId' => $this->getUserId(),
        ]);
    }
}