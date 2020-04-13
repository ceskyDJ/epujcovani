<?php

declare(strict_types = 1);

namespace App\Model;

use App\Database\DB;

/**
 * User manager
 *
 * @author Michal Šmahel (ceskyDJ) <admin@ceskydj.cz>
 * @copyright (C) 2020-Současnost, Michal ŠMAHEL
 * @package App\Model
 */
class UserManager
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
     * Returns user by its ID
     *
     * @param int $id User's ID
     *
     * @return array User
     */
    public function getUser(int $id): array
    {
        $user = $this->db->oneResult("SELECT * FROM `users` WHERE `user_id` = ?", $id);

        $user['full_name'] = "{$user['first_name']} {$user['last_name']}";

        return $user;
    }
}