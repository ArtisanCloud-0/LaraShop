<?php

namespace App\Jobs;

use App\Services\Cart\MergeGuestCartWithUserCartService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class MergeGuestCartJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public int $userId,
        public array $guestCartItems
    ) {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(MergeGuestCartWithUserCartService $service): void
    {
        $service->mergeItems($this->userId, $this->guestCartItems);
    }
}
