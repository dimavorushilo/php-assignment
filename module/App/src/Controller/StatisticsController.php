<?php

namespace App\Controller;

use DateTime;
use SocialPost\Service\SocialPostService;
use Statistics\Builder\ParamsBuilder;
use Statistics\Service\StatisticsService;

/**
 * Class StatisticsController
 *
 * @package App\Controller
 */
class StatisticsController extends Controller
{

    /**
     * @var StatisticsService
     */
    private $statsService;

    /**
     * @var SocialPostService
     */
    private $socialService;

    /**
     * StatisticsController constructor.
     *
     * @param StatisticsService     $statsService
     * @param SocialPostService     $socialService
     */
    public function __construct(
        StatisticsService $statsService,
        SocialPostService $socialService,
    ) {
        $this->statsService  = $statsService;
        $this->socialService = $socialService;
    }

    /**
     * @param array $params
     */
    public function indexAction(array $params)
    {
        try {
            $date   = $this->extractDate($params);
            $params = ParamsBuilder::reportStatsParams($date);

            $posts = $this->socialService->fetchPosts();
            $stats = $this->statsService->calculateStats($posts, $params);

            $response = [
                'stats' => $stats->toArray(),
            ];
        } catch (\Throwable $throwable) {
            http_response_code(500);

            $response = ['message' => 'An error occurred'];
        }

        $this->render($response, 'json', false);
    }

    /**
     * @param array $params
     *
     * @return DateTime
     */
    private function extractDate(array $params): DateTime
    {
        $month = $params['month'] ?? null;
        $date  = DateTime::createFromFormat('F, Y', $month);

        if (false === $date) {
            $date = new DateTime();
        }

        return $date;
    }
}
