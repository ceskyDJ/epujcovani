<?php

declare(strict_types = 1);

namespace App\Model;

use App\Database\DB;
use App\Utils\StringHelper;
use Nette\Database\UniqueConstraintViolationException;
use PDOException;
use function date;
use function end;
use function explode;
use function getimagesize;
use function header;
use function is_uploaded_file;
use function move_uploaded_file;
use function preg_match;
use function unlink;
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
     * @return array|null Car
     */
    public function getCar(int $id): ?array
    {
        try {
            $data = $this->db->oneResult("SELECT * FROM `cars` WHERE `car_id` = ?", $id);
        } catch (PDOException $e) {
            return null;
        }

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

        if (preg_match("%^[A-Za-zĚŠČŘŽÝÁÍÉÚŮĎŤŇěščřžýáíéůúďťň0-9 ]+$%", $name) === 0) {
            return "Chybný formát názvu auta. Povolená jsou velká a malá písmena, číslice a mezery";
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

            header("Location: administrace.php");

            return "Auto bylo úspěšně přidáno";
        } catch (UniqueConstraintViolationException $e) {
            return "Toto auto je již v systému";
        }
    }

    /**
     * Edits an exiting car of the system
     *
     * @param int $id Car's ID
     * @param string $name Car's name
     * @param string $dayPrice Day price of car rent
     * @param array $image Image data
     *
     * @return string Error message
     */
    public function editCar(int $id, string $name, string $dayPrice, array $image): string
    {
        if (empty($id) || empty($name) || empty($dayPrice) || empty($image)) {
            return "Nebyla vyplněna všechna pole";
        }

        if (preg_match("%^[A-Za-zĚŠČŘŽÝÁÍÉÚŮĎŤŇěščřžýáíéůúďťň0-9 ]+$%", $name) === 0) {
            return "Chybný formát názvu auta. Povolená jsou velká a malá písmena, číslice a mezery";
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
            $oldImage = $this->db->oneValue("SELECT `image_name` FROM `cars` WHERE `car_id` = ?", $id);
        } catch (PDOException $e) {
            return "Zadané auto neexistuje";
        }

        unlink(__DIR__."/../../".self::IMAGE_DIR."/{$oldImage}");

        $this->db->withoutResult(
            "
        UPDATE `cars` SET `name` = ?, `day_price` = ?, `image_name` = ? WHERE `car_id` = ?
        ",
            $name,
            $dayPrice,
            $imageName,
            $id
        );

        move_uploaded_file($image['tmp_name'], __DIR__."/../../".self::IMAGE_DIR."/{$imageName}");

        header("Location: administrace.php");

        return "Auto bylo úspěšně upraveno";
    }

    /**
     * Deletes an existing car
     *
     * @param int $id Car's ID
     *
     * @return string Error message
     */
    public function deleteCar(int $id): string
    {
        if (empty($id)) {
            return "Nebylo zadáno ID auta";
        }

        try {
            $carImage = $this->db->oneValue("SELECT `image_name` FROM `cars` WHERE `car_id` = ?", $id);
        } catch (PDOException $e) {
            return "Zadané auto neexistuje";
        }

        $this->db->withoutResult("DELETE FROM `cars` WHERE `car_id` = ?", $id);

        unlink(__DIR__."/../../".self::IMAGE_DIR."/{$carImage}");

        header("Location: administrace.php");

        return "Auto bylo úspěšně smazáno";
    }
}