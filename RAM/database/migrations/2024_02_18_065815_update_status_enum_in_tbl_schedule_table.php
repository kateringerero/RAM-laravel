<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class UpdateStatusEnumInTblScheduleTable extends Migration
{
    public function up()
    {
        // Assuming your database is MySQL, use a raw query to alter the ENUM values
        DB::statement("ALTER TABLE tbl_schedule MODIFY COLUMN status ENUM('pending', 'confirmed', 'cancelled', 'approved', 'rescheduled', 'follow-up', 'released')");
    }

    public function down()
    {
        // Revert back to the original ENUM values
        DB::statement("ALTER TABLE tbl_schedule MODIFY COLUMN status ENUM('pending', 'confirmed', 'cancelled')");
    }
}
