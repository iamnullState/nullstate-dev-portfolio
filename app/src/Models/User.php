<?php
declare(strict_types=1);

namespace Nullstate\Models;

use Illuminate\Database\Eloquent\Model;

final class User extends Model {
    protected $table = 'users';
    protected $fillable = ['email','username','password_hash','role_id'];
    protected $hidden = ['password_hash'];
    public $timestamps = true;

    public function role() { return $this->belongsTo(Role::class, 'role_id'); }
}