<?php
declare(strict_types=1);

namespace Nullstate\Models;

use Illuminate\Database\Eloquent\Model;

final class User extends Model
{
    protected $table = 'users';
    protected $fillable = ['name', 'email']; // mass-assignable
    public $timestamps = true;               // expects created_at/updated_at
}