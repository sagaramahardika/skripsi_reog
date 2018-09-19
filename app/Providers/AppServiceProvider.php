<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Dosen;
use Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('check_kaprodi', function($attribute, $value, $parameters, $validator) {
            if ( $value == 0 ) {
                $check_kaprodi = Dosen::where('jabatan', 1)->first();

                if ( empty($check_kaprodi) ) {
                    return true;
                } else {
                    return false;
                }

            } else {
                return true;
            }
        });

        Validator::replacer('check_kaprodi', function($message, $attribute, $rule, $parameters) {
            return "Sudah ada kaprodi yang menjabat";
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
