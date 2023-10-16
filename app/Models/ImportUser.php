<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property int $age
 */
class ImportUser extends Model
{
    use HasFactory;

    protected $casts = [
        'age' => 'integer',
    ];
}
