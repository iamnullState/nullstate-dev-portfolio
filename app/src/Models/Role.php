<?php
declare(strict_types=1);

namespace Nullstate\Models;

use Illuminate\Database\Eloquent\Model;

final class Role extends Model {
    protected $table = 'roles';
    public $timestamps = false;
    protected $fillable = ['slug','label'];
}
