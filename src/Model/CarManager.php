<?php

declare(strict_types = 1);

namespace App\Model;

use App\Database\DB;
use App\Utils\StringHelper;
use Nette\Database\UniqueConstraintViolationException;
use function date;
use function explode;
use function getimagesize;
use function is_uploaded_file;
use function move_uploaded_file;
use function preg_match;
use const UPLOAD_ERR_OK;

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
     * Directory for storing images
     */
    const IMAGE_DIR = "www/img/cars";

    /**
     * @var \App\Database\DB
     */
    private $db;
    /**
     * @var \App\Utils\StringHelper
     */
    private $stringHelper;

    /**
     * CarManager constructor
     *
     * @param \App\Database\DB $db
     * @param \App\Utils\StringHelper $stringHelper
     */
    public function __construct(DB $db, StringHelper $stringHelper)
    {
        $this->db = $db;
        $this->stringHelper = $stringHelper;
    }

    /**
     * Returns all cars
     *
     * @return array Cars ordered by their price
     */
    public function getCars(): array
    {
        $data = $this->db->moreResults("SELECT * FROM `cars` ORDER BY `day_price`");

        return $this->stringHelper->treatArray($data);
    }

    /**
     * Return car by its ID
     *
     * @param int $id Car's ID
     *
     * @return array Car
     */
    public function getCar(int $id): array
    {
        $data = $this->db->oneResult("SELECT * FROM `cars` WHERE `car_id` = ?", $id);

        return $this->stringHelper->treatArray($data);
    }

    /**
     * Adds a new car to the system
     *
     * @param string $name Car's name
     * @param string $dayPrice Day price of car rent
     * @param array $image Image data
     *
     * @return string Error message
     */
    public function addCar(string $name, string $dayPrice, array $image): string
    {
        if (empty($name) || empty($dayPrice) || empty($image)) {
            return "Nebyla vyplněna všechna pole";
        }

        if (preg_match("%^\d+$%", $dayPrice) === 0) {
            return "Neplatný formát ceny";
        }

        if ($image['error'] !== UPLOAD_ERR_OK || is_uploaded_file($image['tmp_name']) === false) {
            return "Chyba při nahrávání obrázku";
        }

        $imageData = getimagesize($image['tmp_name']);
        if ($imageData === false || $imageData[0] === 0 || $imageData[1] === 0
            || preg_match(
                "%^image/%",
                $imageData['mime']
            ) === 0) {
            return "Neplatný obrázek";
        }

        $imageNameParts = explode(".", $image['name']);
        $imageExtension = end($imageNameParts);
        $imageName = date("YmdHis").".{$imageExtension}";

        try {
            $this->db->withoutResult(
                "
            INSERT INTO `cars`(`name`, `day_price`, `image_name`) VALUES(?, ?, ?)
            ",
                $name,
                $dayPrice,
                $imageName
            );

            move_uploaded_file($image['tmp_name'], __DIR__."/../../".self::IMAGE_DIR."/{$imageName}");

            return "Auto bylo úspěšně přidáno";
        } catch (UniqueConstraintViolationException $e) {
            return "Toto auto je již v systému";
        }
    }
}