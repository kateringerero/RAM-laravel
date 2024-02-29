<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TblSchedule extends Model
{



    protected $table = 'tbl_schedule';

    public function user(){
        return $this->belongsTo(TblUser::class, 'creator_id', 'user_id');
    }

    public function handler(){
        return $this->belongsTo(TblUser::class, 'handled_by', 'user_id');
    }




}

