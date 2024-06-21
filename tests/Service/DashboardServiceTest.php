<?php

namespace App\Tests\Service;

use App\Entity\TicketsStatistic;
use App\Repository\DashboardRepository;
use App\Repository\TicketsStatisticRepository;
use App\Service\DashboardService;
use App\Transformer\TicketStatisticTransformer;
use PHPUnit\Framework\TestCase;

class DashboardServiceTest extends TestCase
{
    public function testGetDashboardData()
    {
        $dashboardService =$this->createDashboardService();
        $result = $dashboardService->getDashboardData();

        $this->assertIsArray($result);
    }

    public function createDashboardService(): DashboardService
    {
        $ticketStatistic = $this->getMockBuilder(TicketsStatistic::class)->disableOriginalConstructor()->getMock();
        $ticketStatisticTransformer = $this->getMockBuilder(TicketStatisticTransformer::class)->disableOriginalConstructor()->getMock();
        $ticketStatisticTransformer->expects($this->any())->method('toArrayList')->willReturn([$ticketStatisticTransformer]);
        $ticketStatisticRepository = $this->getMockBuilder(TicketsStatisticRepository::class)->disableOriginalConstructor()->getMock();
        $ticketStatisticRepository->expects($this->any())->method('findAll')->willReturn([$ticketStatistic]);
        $dashBoardRepository = $this->getMockBuilder(DashboardRepository::class)->disableOriginalConstructor()->getMock();

        return new DashboardService($dashBoardRepository, $ticketStatisticRepository, $ticketStatisticTransformer);
    }
}
