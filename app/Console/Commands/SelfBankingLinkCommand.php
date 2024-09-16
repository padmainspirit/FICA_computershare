<?php

namespace App\Console\Commands;

use App\Http\Controllers\CronJobController;
use Illuminate\Console\Command;

class SelfBankingLinkCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sblink:autoexpiry';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "This command was written by Padma to automatically expire links if they haven't failed or completed";

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $CronJobController = new CronJobController;
		return $CronJobController->checksbLInks();
    }
}
