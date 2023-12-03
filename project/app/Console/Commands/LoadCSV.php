<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Helpers\EmployeesHelper;
use Exception;

class LoadCSV extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:loadcsv {--file=}';

    /**
     * Parser of CSV file with employees and organizations
     *
     * @var string
     */
    protected $description = 'Parser of CSV file with employees and organizations';

    public function handle(): void
    {
        try {
            $parser = new EmployeesHelper();
            $parser->loadFromCSV($this->option('file'));
        } catch (Exception $e) {
            var_export([
                $e->getMessage(),
                $e->getTraceAsString(),
            ]);
        } finally {
            print('DONE' . PHP_EOL);
        }
    }
}
