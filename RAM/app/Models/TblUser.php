<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class TblUser extends Model
{
    use HasApiTokens;
    protected $table = 'tbl_users';

    protected $fillable =
        [
        'user_id',
        'first_name',
        'last_name',
        'middle_name',
        'email_address',
        'password',
        'role',
        ];


    public function schedules() {
        return $this->hasMany(TblSchedule::class, 'creator_id', 'user_id');
    }
}
