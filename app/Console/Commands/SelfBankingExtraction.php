<?php

namespace App\Console\Commands;

use App\Http\Controllers\BulkExtractioncontroller;
use Illuminate\Console\Command;

class SelfBankingExtraction extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sb:extraction';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command is for generating extractions of self banking in PDF format';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $BulkExtractioncontroller = new BulkExtractioncontroller;
		return $BulkExtractioncontroller->generateSelfBankingPDF();
    }
}
