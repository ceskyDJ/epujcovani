<?php

declare(strict_types = 1);

namespace App\Model;

use App\Database\DB;

/**
 * Car manager
 *
 * @author Michal Šmahel (ceskyDJ) <admin@ceskydj.cz>
 * @copyright (C) 2020-Současnost, Michal ŠMAHEL
 * @package App\Model
 */
class CarManager
{
    /**
     * @var \App\Database\DB
     */
    private $db;

    /**
     * CarManager constructor
     *
     * @param \App\Database\DB $db
     */
    public function __construct(DB $db)
    {
        $this->db = $db;
    }

    /**
     * Returns all cars
     *
     * @return array Cars ordered by their price
     */
    public function getCars(): array
    {
        return $this->db->moreResults("
            SELECT * FROM `cars` ORDER BY `day_price`
        ");
    }
}