<?php

declare(strict_types=1);

namespace App\Users\Infrastructure\Eloquent;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserModel extends Model
{
    use HasFactory;

    protected $keyType = 'string';

    protected $primaryKey = 'id';

    protected $table = 'users';

    public $incrementing = false;

    public $timestamps = false;
}
