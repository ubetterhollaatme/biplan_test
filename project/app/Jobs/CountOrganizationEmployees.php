<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class CountOrganizationEmployees implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        DB::table('organizations')
            ->select('id')
            ->lazyById()
            ->each(function(object $org) {
                DB::table('employees_count_in_org')
                    ->upsert(
                        [
                            [
                                'org_id' => $org->id,
                                'employees_count' => DB::table('employees')
                                    ->where('org_id', $org->id)
                                    ->count(),
                            ]
                        ],
                        ['org_id'],
                        ['employees_count']
                    );
            });
    }
}
