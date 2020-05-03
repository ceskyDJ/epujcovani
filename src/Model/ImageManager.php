<?php

declare(strict_types = 1);

namespace App\Model;

use App\Utils\StringHelper;
use function array_diff;
use function array_shift;
use function array_unshift;
use function scandir;

/**
 * Class ImageManager
 *
 * @author Michal Šmahel (ceskyDJ) <admin@ceskydj.cz>
 * @copyright (C) 2020-Současnost, Michal ŠMAHEL
 * @package App\Model
 */
class ImageManager
{
    /**
     * Directory for storing images
     */
    const IMAGE_DIR = "www/img/cars";

    /**
     * @var \App\Utils\StringHelper
     */
    private $stringHelper;

    /**
     * ImageManager constructor
     *
     * @param \App\Utils\StringHelper $stringHelper
     */
    public function __construct(StringHelper $stringHelper)
    {
        $this->stringHelper = $stringHelper;
    }

    /**
     * Returns all uploaded images
     *
     * @return array Uploaded images
     */
    public function getAllImages(): array
    {
        $images = scandir(__DIR__."/../../".self::IMAGE_DIR);

        $images = array_diff($images, [".", ".."]);

        return $this->stringHelper->treatArray($images);
    }
}