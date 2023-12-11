<?php

namespace Modules\Rentalcars\Models;

use Tamm\Framework\Skeleton\Web\IRequestModel;

/**
 * Interface IRequestModel
 *
 * @author  Abdullah Sowailem <abdullah.sowailem@gmail.com>
 * @package Tamm\Framework\Skeleton\Web
 */

// class UpdateCarRequest implements IRequestModel {

// }

class UpdateCarRequest implements IRequestModel {
    private string $name;
    private string $model;
    private string $year;
}