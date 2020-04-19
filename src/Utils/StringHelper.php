<?php

declare(strict_types = 1);

namespace App\Utils;

use Nette\Database;
use function bdump;
use function htmlspecialchars;
use function is_array;
use function is_float;
use function is_int;
use function is_object;
use function strip_tags;
use const ENT_QUOTES;

/**
 * String helper
 *
 * @author Michal Šmahel (ceskyDJ) <admin@ceskydj.cz>
 * @copyright (C) 2020-Současnost, Michal ŠMAHEL
 * @package App\Utils
 */
class StringHelper
{
    /**
     * Treats output array
     *
     * @param array $output Array
     *
     * @return array 'Clean' array
     */
    public function treatArray(array $output): array
    {
        foreach ($output as &$item) {
            if (is_array($item)) {
                $item = $this->treatArray($item);
            } elseif ($item instanceof Database\Row) {
                $item = $this->treatArray((array)$item);
            } else {
                $item = $this->treatVar($item);
            }
        }

        return $output;
    }

    /**
     * Treats output variable
     *
     * @param mixed $variable Variable
     *
     * @return mixed 'Clean' variable
     */
    public function treatVar($variable)
    {
        if (is_object($variable) | is_float($variable) | is_int($variable)) {
            return $variable;
        }

        return htmlspecialchars(strip_tags($variable), ENT_QUOTES);
    }
}