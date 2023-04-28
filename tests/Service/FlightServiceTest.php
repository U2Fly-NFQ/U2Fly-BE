<?php

namespace App\Tests\Service;

use App\Entity\Flight;
use App\Entity\SeatType;
use App\Repository\FlightRepository;
use App\Repository\FlightSeatTypeRepository;
use App\Request\ListFlightRequest;
use App\Service\FlightService;
use App\Transformer\FlightSeatTypeTransformer;
use App\Transformer\FlightTransformer;
use PHPUnit\Framework\TestCase;

class FlightServiceTest extends TestCase
{
    public function testFind()
    {
        $listFlightRequestParam['criteria']['roundtrip']['startDate'] = null;
        $listFlightRequestParam['criteria']['oneway']['startDate'] = '2000-1-1';
        $listFlightRequestParam['criteria']['oneway']['departure'] = 'HN';
        $listFlightRequestParam['criteria']['oneway']['arrival'] = 'ACV';
        $listFlightRequestParam['criteria']['oneway']['pagination']['page'] = 5;
        $listFlightRequestParam['criteria']['oneway']['pagination']['offset'] = 5;
        $listFlightRequest = $this->getMockBuilder(ListFlightRequest::class)->disableOriginalConstructor()->getMock();
        $listFlightRequest->expects($this->any())->method('splitOneWayAndRoundTrip')->willReturn($listFlightRequestParam);
        $listFlightRequest->expects($this->any())->method('getSeatType')->willReturn('classic');
        $listFlightRequest->expects($this->any())->method('getSeatTypeRoundTrip')->willReturn('oneway');

        $flightService = $this->createFlightService();
        $result = $flightService->find($listFlightRequest);

        $this->assertIsArray($result);
    }

    public function createFlightService()
    {
        $flight = $this->getMockBuilder(Flight::class)->disableOriginalConstructor()->getMock();
        $flightSeatTypeTransformer = $this->getMockBuilder(FlightSeatTypeTransformer::class)->disableOriginalConstructor()->getMock();
        $flightSeatTypeRepository = $this->getMockBuilder(FlightSeatTypeRepository::class)->disableOriginalConstructor()->getMock();
        $flightTransformer = $this->getMockBuilder(FlightTransformer::class)->disableOriginalConstructor()->getMock();
        $flightRepository = $this->getMockBuilder(FlightRepository::class)->disableOriginalConstructor()->getMock();
        $flightRepository->expects($this->any())->method('oneWayLimit')->willReturn($flight);

        return new FlightService($flightRepository, $flightTransformer,$flightSeatTypeRepository,$flightSeatTypeTransformer );
    }
}
