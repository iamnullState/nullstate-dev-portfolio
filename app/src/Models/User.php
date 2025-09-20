<?php
declare(strict_types=1);

namespace Nullstate\Models;

use Illuminate\Database\Eloquent\Model;

final class User extends Model
{
    protected $table = 'users';
    protected $fillable = ['email', 'username', 'password_hash', 'is_admin'];
    protected $hidden = ['password_hash'];
    public $timestamps = true;
}