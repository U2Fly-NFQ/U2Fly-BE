<?php

namespace App\Service;

use App\Entity\AbstractEntity;
use App\Entity\Account;
use App\Entity\Passenger;
use App\Mapper\PassengerRequestMapper;
use App\Repository\PassengerRepository;
use App\Request\PassengerRequest\AddPassengerRequest;

class PassengerService
{
    private PassengerRequestMapper $passengerRequestMapper;
    private PassengerRepository $passengerRepository;

    /**
     * @param PassengerRequestMapper $passengerRequestMapper
     * @param PassengerRepository $passengerRepository
     */
    public function __construct(PassengerRequestMapper $passengerRequestMapper, PassengerRepository $passengerRepository)
    {
        $this->passengerRequestMapper = $passengerRequestMapper;
        $this->passengerRepository = $passengerRepository;
    }

    public function add(AddPassengerRequest $addPassengerRequest, Account $account): AbstractEntity
    {
        $passenger = $this->passengerRequestMapper->mapper($addPassengerRequest, $account);

        return $this->passengerRepository->create($passenger, true);
    }
    
    public function find(Passenger $passenger)
    {
        return $this->passengerRepository->find($passenger);
    }
}