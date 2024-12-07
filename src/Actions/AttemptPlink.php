<?php

declare(strict_types=1);

namespace BenBjurstrom\Plink\Actions;

use BenBjurstrom\Plink\Enums\PlinkStatus;
use BenBjurstrom\Plink\Exceptions\PlinkAttemptException;
use BenBjurstrom\Plink\Models\Plink;
use Illuminate\Support\Carbon;

class AttemptPlink
{
    /**
     * @throws PlinkAttemptException
     */
    public function handle(int $id): Plink
    {
        $this->validateSignature();
        $plink = Plink::findOrFail($id);
        $this->validateStatus($plink);
        $this->validateNotExpired($plink);
        $this->validateSession();

        // if everything above passes mark the plink as used
        $plink->update(['status' => PlinkStatus::USED]);

        return $plink;
    }

    /**
     * @throws PlinkAttemptException
     */
    protected function validateStatus(Plink $plink): void
    {
        if ($plink->status !== PlinkStatus::ACTIVE) {
            throw new PlinkAttemptException($plink->status->errorMessage());
        }
    }

    /**
     * @throws PlinkAttemptException
     */
    protected function validateNotExpired(Plink $plink): void
    {
        if ($plink->created_at->lt(Carbon::now()->subMinutes(5))) {
            $plink->update(['status' => PlinkStatus::EXPIRED]);
            throw new PlinkAttemptException($plink->status->errorMessage());
        }
    }

    /**
     * @throws PlinkAttemptException
     */
    protected function ValidateSignature(): void
    {
        if (! request()->hasValidSignature()) {
            if (! url()->signatureHasNotExpired(request())) {
                throw new PlinkAttemptException(PlinkStatus::EXPIRED->errorMessage());
            }

            throw new PlinkAttemptException(PlinkStatus::INVALID->errorMessage());
        }
    }

    /**
     * @throws PlinkAttemptException
     */
    protected function ValidateSession(): void
    {
        if (request()->get('session') !== session()->getId()) {
            throw new PlinkAttemptException(PlinkStatus::SESSION->errorMessage());
        }
    }
}
