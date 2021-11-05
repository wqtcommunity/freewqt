<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Task;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Admin::create([
            'id' => 1,
            'username' => 'admin',
            'password' => password_hash('Test@123', PASSWORD_DEFAULT)
        ]);

        Task::insert([
            [
                'round_id'       => 1,
                'title'          => "Get your first ticket instantly",
                'description'    => "Everyone can have a chance in the next airdrop, your first ticket does not require doing any tasks! simply click the button below.",
                'difficulty'      => 'instant',
                'link'           => null,
                'tickets'        => 1,
                'input_required' => false,
                'input_title'    => false
            ],[
                'round_id'       => 1,
                'title'          => "Join WorkQuest's Official Telegram Group",
                'description'    => "Please click the link below and join WorkQuest's Official Telegram Group. Then enter your username and submit the form.",
                'difficulty'      => 'easy',
                'link'           => 'https://t.me/WorkQuestChat',
                'tickets'        => 1,
                'input_required' => true,
                'input_title'    => 'Your Telegram Username'
            ],[
                'round_id'       => 1,
                'title'          => "Retweet",
                'description'    => "Retweet the Pinned Tweet on WorkQuest's Twitter account while tagging 3 of your friends and paste the link of your retweet below.",
                'difficulty'      => 'normal',
                'link'           => 'https://twitter.com/workquest_co',
                'tickets'        => 2,
                'input_required' => true,
                'input_title'    => 'Retweet Link'
            ],[
                'round_id'       => 1,
                'title'          => "Follow WorkQuest on Twitter",
                'description'    => "Please click the link below and Follow WorkQuest on Twitter. Then enter your username and submit the form.",
                'difficulty'      => 'easy',
                'link'           => 'https://twitter.com/workquest_co',
                'tickets'        => 1,
                'input_required' => true,
                'input_title'    => 'Your Twitter Username'
            ],[
                'round_id'       => 1,
                'title'          => "Add WorkQuest to your Watchlist on CoinMarketCap",
                'description'    => "We will not be able to verify this task, but we would appreciate if you add WorkQuest to your Watchlist on CoinMarketCap. simply click Get Ticket button below to get your ticket.",
                'difficulty'      => 'instant',
                'link'           => 'https://coinmarketcap.com/currencies/workquest/',
                'tickets'        => 1,
                'input_required' => false,
                'input_title'    => null
            ],
        ]);
    }
}
