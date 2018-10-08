<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\Models\Access\User\User;
use App\Http\Controllers\Controller;
use App\Repositories\Frontend\Access\User\UserRepository;
use App\Notifications\Frontend\Auth\UserNeedsConfirmation;

/**
 * Class ConfirmAccountController.
 */
class ConfirmAccountController extends Controller
{
    /**
     * @var UserRepository
     */
    protected $user;

    /**
     * ConfirmAccountController constructor.
     *
     * @param UserRepository $user
     */
    public function __construct(UserRepository $user)
    {
        $this->user = $user;
    }

    /**
     * @param $token
     *
     * @return mixed
     */
    public function confirm($token)
    {
        $user = $this->user->findByConfirmationToken($token);

        if($user != null)
        {
            if($this->user->isAdmin($user))
            {
                $this->user->confirmAccount($token);

                return redirect()->route('frontend.auth.login')->withFlashSuccess(trans('exceptions.frontend.auth.confirmation.success'));
            }
        }

        return redirect()->route('frontend.auth.login')->withFlashDanger('These credentials do not match our records.');
    }

    /**
     * @param $user
     *
     * @return mixed
     */
    public function sendConfirmationEmail(User $user)
    {
        if($user != null)
        {
            if($this->user->isAdmin($user))
            {
                $user->notify(new UserNeedsConfirmation($user->confirmation_code));
                return redirect()->route('frontend.auth.login')->withFlashSuccess(trans('exceptions.frontend.auth.confirmation.resent'));
            }
        }
        return redirect()->route('frontend.auth.login')->withFlashDanger('These credentials do not match our records.');
    }
}
