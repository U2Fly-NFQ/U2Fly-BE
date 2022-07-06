<?php

namespace App\Repository;

use App\Entity\Flight;
use App\Entity\Passenger;
use App\Entity\Ticket;
use App\Request\TicketRequest;
use App\Traits\TransferTrait;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Cache\ArrayResult;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;

/**
 *
 * @method Ticket|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ticket|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ticket[]    findAll()
 * @method Ticket[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TicketRepository extends BaseRepository
{
    const TICKET_ALIAS = 'tk';
    const PASSENGER_ALIAS = 'p';

    use TransferTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ticket::class);
    }


    public function getAll($ticketRequest)
    {
        $ticket = $this->createQueryBuilder(static::TICKET_ALIAS);
        $ticket =  $this->join($ticket);
        $listTicketRequest = $this->objectToArray($ticketRequest);
        $this->addWhere($listTicketRequest, $ticket);
        $query = $ticket->getQuery();

        return $query->getResult();
    }

    public function update(Ticket $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }


    private function join($ticket)
    {
        $ticket->join(Passenger::class, self::PASSENGER_ALIAS, Join::WITH, self::TICKET_ALIAS . '.passenger =' . self::PASSENGER_ALIAS . '.id');
        return $ticket;
    }

    private function addWhere($listTicketRequest, $ticket)
    {
        foreach ($listTicketRequest as $key => $value) {
            if ($value != null) {
                $ticket->andWhere(self::TICKET_ALIAS . '.' . $key . ' = ' . '\'' . $value . '\'');
            }
        }
    }

    public function create(Ticket $entity, bool $flush = false): Ticket
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
        return $entity;
    }
}
