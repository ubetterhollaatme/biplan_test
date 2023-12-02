<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Helpers\EmployeesHelper;

class LoadCSV extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:loadcsv {--file=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parser of CSV file with employees and organizations';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        EmployeesHelper::loadFromCSV($this->option('file'));
    }
}
