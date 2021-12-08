<?php

namespace App\Observers;

use App\Models\AppSetting;
use App\Models\User;
use App\Models\Setting;
use App\Models\Portfolio;
use App\Models\Subscription;

class UserObserver
{
    /**
     * Handle the User "created" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function created(User $user)
    {
        Setting::create([
            'user_id' => $user->id
        ]);

        $freeDays = 0;
        $appSetting = AppSetting::where('name', 'trial')->first();
        $appSettingData = json_decode($appSetting->data, true);
        if ($appSettingData['active']) {
            $freeDays = $appSettingData['duration'];
        }

        Subscription::create([
            'user_id' => $user->id,
            'type' => 'free',
            'expired_at' => now()->addDays($freeDays),
        ]);
    }

    /**
     * Handle the User "updated" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function updated(User $user)
    {
        //
    }

    /**
     * Handle the User "deleted" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function deleted(User $user)
    {
        //
    }

    /**
     * Handle the User "restored" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function restored(User $user)
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function forceDeleted(User $user)
    {
        //
    }
}
