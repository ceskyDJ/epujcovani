<?php

declare(strict_types = 1);

namespace App\Model;

use App\Database\DB;
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
     * RentManager constructor
     *
     * @param \App\Database\DB $db
     */
    public function __construct(DB $db)
    {
        $this->db = $db;
    }

    /**
     * Returns actual rents
     *
     * @return array Rents ordered by date of rent
     */
    public function getActualRents(): array
    {
        $rents = $this->db->moreResults(
            "
            SELECT `car_rents`.`from`, `car_rents`.`to`,
                   `cars`.`name` AS `car_name`, `cars`.`day_price` AS `car_day_price`, `cars`.`image_name` AS `car_image`,
                   CONCAT(`users`.`first_name`, ' ', `users`.`last_name`) AS `user_full_name`, `users`.`email` AS `user_email`, `users`.`phone` AS `user_phone`
            FROM `car_rents`
            JOIN `cars` USING (`car_id`)
            JOIN `users` USING (`user_id`)
            WHERE `car_rents`.`to` > NOW()
            ORDER BY `car_rents`.`from`
        "
        );

        foreach ($rents as &$rent) {
            // No sense to calculate, when it's one-day rent
            if ($rent['from']->getTimestamp() === $rent['to']->getTimestamp()) {
                $rent['length'] = "1 den";
                $rent['price'] = $rent['car_day_price'];

                continue;
            }

            $length = (date_diff($rent['to'], $rent['from']))->days + 1;

            $rent['length'] = $length < 5 ? "{$length} dny" : "{$length} dní";
            $rent['price'] = $rent['car_day_price'] * $length;
        }

        return $rents;
    }
}