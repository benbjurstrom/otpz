<?php

namespace BenBjurstrom\Plink\Http\Controllers;

use BenBjurstrom\Plink\Actions\AttemptPlink;
use BenBjurstrom\Plink\Exceptions\PlinkAttemptException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class GetPlinkController
{
    public function __invoke(int $id): RedirectResponse|View
    {
        try {
            $plink = (new AttemptPlink)->handle($id);

            Auth::loginUsingId($plink->user_id); // fires Illuminate\Auth\Events\Login;
            Session::regenerate();

            if (! $plink->user->hasVerifiedEmail()) {
                $plink->user->markEmailAsVerified();
            }

            return redirect()->intended('/dashboard');
        } catch (PlinkAttemptException $e) {
            return view('plink::error', [
                'message' => $e->getMessage(),
            ]);
        }
    }
}
