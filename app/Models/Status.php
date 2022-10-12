<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed|string $name
 * @property mixed|string $model
 * @property mixed|string $translation_status
 */
class Status extends Model
{
    use HasFactory;
}
