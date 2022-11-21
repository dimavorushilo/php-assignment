<?php

namespace Tests\unit\Statistics\Calculator;

use DateTime;
use PHPUnit\Framework\TestCase;
use SocialPost\Dto\SocialPostTo;
use Statistics\Calculator\AverageUserPost;
use Statistics\Dto\ParamsTo;
use Statistics\Enum\StatsEnum;

class AverageUserPostTest extends TestCase
{

    /**
     * @var AverageUserPost
     */
    private $calculator;

    protected function setUp(): void
    {
        $params = (new ParamsTo())
            ->setStatName(StatsEnum::AVERAGE_POST_NUMBER_PER_USER)
            ->setStartDate(DateTime::createFromFormat(DateTime::ATOM, "2018-08-01T00:00:00+00:00"))
            ->setEndDate(DateTime::createFromFormat(DateTime::ATOM, "2018-08-31T00:00:00+00:00"));

        $this->calculator = (new AverageUserPost())
            ->setParameters($params);
    }

    public function testStatisticsType(): void
    {
        $this->assertEquals(StatsEnum::AVERAGE_POST_NUMBER_PER_USER, $this->calculator->getStatisticsType());
    }

    /**
     * @dataProvider calculateDataProvider
     *
     * @param array $posts
     * @param array $expectedData
     */
    public function testCalculate(array $posts, array $expectedData): void
    {
        foreach ($posts as $post) {
            $this->calculator->accumulateData($post);
        }

        $statistic = $this->calculator->calculate();

        $this->assertEquals($expectedData, $statistic->toArray());
    }

    public function calculateDataProvider(): array
    {
        return [
            'Calculate zero posts' => [
                'posts' => [],
                'expectedData' => [
                    'name' => 'average-posts-per-user',
                    'label' => 'Average number of posts per user in a given month',
                    'value' => null,
                    'units' => 'posts',
                    'children' => null,
                ],
            ],
            'Calculate one post' => [
                'posts' => [
                    (new SocialPostTo())
                        ->setAuthorId('Author_1')
                        ->setDate(DateTime::createFromFormat(DateTime::ATOM, "2018-08-11T06:38:54+00:00"))
                ],
                'expectedData' => [
                    'name' => 'average-posts-per-user',
                    'label' => 'Average number of posts per user in a given month',
                    'value' => null,
                    'units' => 'posts',
                    'children' => [
                        [
                            'name' => 'average-posts-per-user',
                            'userId' => 'Author_1',
                            'value' => 1.0,
                            'label' => null,
                            'units' => 'posts',
                            'children' => null,
                        ],
                    ],
                ],
            ],
            'Calculate two authors and three posts' => [
                'posts' => [
                    (new SocialPostTo())
                        ->setAuthorId('Author_1')
                        ->setDate(DateTime::createFromFormat(DateTime::ATOM, "2018-08-11T06:38:54+00:00")),
                    (new SocialPostTo())
                        ->setAuthorId('Author_2')
                        ->setDate(DateTime::createFromFormat(DateTime::ATOM, "2018-08-12T06:38:54+00:00")),
                    (new SocialPostTo())
                        ->setAuthorId('Author_1')
                        ->setDate(DateTime::createFromFormat(DateTime::ATOM, "2018-08-13T06:38:54+00:00")),
                ],
                'expectedData' => [
                    'name' => 'average-posts-per-user',
                    'label' => 'Average number of posts per user in a given month',
                    'value' => null,
                    'units' => 'posts',
                    'children' => [
                        [
                            'name' => 'average-posts-per-user',
                            'userId' => 'Author_1',
                            'value' => 2.0,
                            'label' => null,
                            'units' => 'posts',
                            'children' => null,
                        ],
                        [
                            'name' => 'average-posts-per-user',
                            'userId' => 'Author_2',
                            'value' => 1.0,
                            'label' => null,
                            'units' => 'posts',
                            'children' => null,
                        ],
                    ],
                ],
            ],
        ];
    }
}
