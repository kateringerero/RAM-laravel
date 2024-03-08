<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\TblSchedule;

class CancelNoShowAppointments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'appointments:cancel-no-show';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cancels appointments where the attendee did not show up.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $now = now();
    TblSchedule::where('status', 'pending')
        ->where('scheduled_date', '<', $now)
        ->update(['status' => 'cancelled_no_show']);

    $this->info('Pending appointments updated successfully.');
    }
}
