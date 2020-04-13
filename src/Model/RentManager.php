<?php

declare(strict_types = 1);

namespace App\Model;

use App\Database\DB;
use Nette\Utils\DateTime;
use function bdump;
use function date_diff;

/**
 * Rent manager
 *
 * @author Michal Šmahel (ceskyDJ) <admin@ceskydj.cz>
 * @copyright (C) 2020-Současnost, Michal ŠMAHEL
 * @package App\Model
 */
class RentManager
{
    /**
     * @var \App\Database\DB
     */
    private $db;
    /**
     * @var \App\Model\CarManager
     */
    private $carManager;
    /**
     * @var \App\Model\UserManager
     */
    private $userManager;

    /**
     * RentManager constructor
     *
     * @param \App\Database\DB $db
     * @param \App\Model\CarManager $carManager
     * @param \App\Model\UserManager $userManager
     */
    public function __construct(
        DB $db,
        CarManager $carManager,
        UserManager $userManager
    ) {
        $this->db = $db;
        $this->carManager = $carManager;
        $this->userManager = $userManager;
    }

    /**
     * Returns actual rents
     *
     * @return array Rents ordered by date of rent
     */
    public function getActualRents(): array
    {
        $rents = $this->db->moreResults("SELECT * FROM `car_rents` WHERE `to` > NOW() ORDER BY `from`");

        foreach ($rents as &$rent) {
            $rent['user'] = $this->userManager->getUser($rent['user_id']);
            $rent['car'] = $this->carManager->getCar($rent['car_id']);

            // No sense to calculate, when it's one-day rent
            if ($rent['from']->getTimestamp() === $rent['to']->getTimestamp()) {
                $rent['length'] = "1 den";
                $rent['price'] = $rent['car']['day_price'];

                continue;
            }

            $length = (date_diff($rent['to'], $rent['from']))->days + 1;

            $rent['length'] = $length < 5 ? "{$length} dny" : "{$length} dní";
            $rent['price'] = $rent['car']['day_price'] * $length;
        }

        return $rents;
    }
}