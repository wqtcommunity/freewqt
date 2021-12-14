<?php

namespace App\Http\Traits;

use App\Models\Subscription;
use App\Models\User;
use App\Models\UserTask;

trait SubscribeTrait
{
    public function subscribe($email, $telegram=null): bool|string
    {
        // Already Subscribed?
        if($this->already_subscribed($email, $telegram)){
            return 'You are already subscribed!';
        }

        $user_id = null;

        if(auth()->check()){
            $user_id = auth()->user()->id;
        }else{
            if($find_email = User::where('email', $email)->first()){
                $user_id = $find_email->id;
            }elseif($find_telegram = UserTask::where('primary_input', $telegram)->orWhere('primary_input', str_replace('@', '', $telegram))->first()){
                $user_id = $find_telegram->user_id;
            }
        }

        $subscribe = Subscription::create([
            'user_id' => $user_id,
            'email' => $email,
            'telegram' => $telegram
        ]);

        if($subscribe){
            return true;
        }

        return false;
    }

    public function already_subscribed($email=false, $telegram=false): bool
    {
        if($email){
            if(Subscription::where('email', $email)->first()){
                return true;
            }
        }

        if($telegram){
            if(Subscription::where('telegram', $telegram)->first()){
                return true;
            }
        }

        if(auth()->check()){
            $user_id = auth()->user()->id;
            if(Subscription::where('user_id', $user_id)->first()){
                return true;
            }
        }

        return false;
    }
}