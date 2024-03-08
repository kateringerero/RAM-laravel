<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class UpdateStatusEnumInTblScheduleTable extends Migration
{
    // KENTH - dinagdag ko yung 'done' para sa done na switch sa update ng appointment
    public function up()
    {
        // Assuming your database is MySQL, use a raw query to alter the ENUM values
        DB::statement("ALTER TABLE tbl_schedule MODIFY COLUMN status ENUM('pending', 'confirmed', 'cancelled', 'approved', 'rescheduled', 'follow-up', 'released', 'done', 'rescheduled_by_user')");
    }
    // KENTH

    public function down()
    {
        // Revert back to the original ENUM values
        DB::statement("ALTER TABLE tbl_schedule MODIFY COLUMN status ENUM('pending', 'confirmed', 'cancelled', 'approved', 'rescheduled', 'follow-up', 'released', 'done')");
    }
}
