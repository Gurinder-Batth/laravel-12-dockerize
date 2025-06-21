<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class TestHorizonJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        Log::info("✅ TestHorizonJob executed at " . now());
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::info("✅ Running TestHorizonJob at " . now());
    }
}
