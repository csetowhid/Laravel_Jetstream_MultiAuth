<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;
use Illuminate\Support\Facades\Auth;
// use App\Guards\AdminStatefulGuard;
use Illuminate\Contracts\Auth\StatefulGuard;
use App\Http\Controllers\AdminController;
use App\Actions\Fortify\RedirectIfTwoFactorAuthenticatable;
use App\Actions\Fortify\AttemptToAuthenticate;
class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->when([AdminController::class, 
                AttemptToAuthenticate::class, 
                    RedirectIfTwoFactorAuthenticatable::class])
                    ->needs(StatefulGuard::class)
                    ->give(function(){
                        return Auth::guard('admin');
                    });
        // $this->app->bind(StatefulGuard::class, function () {
        //     return Auth::guard('admin');
        // });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);
    }
}
