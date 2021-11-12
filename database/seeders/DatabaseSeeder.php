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
                'title'          => "Add WorkQuest to your CoinMarketCap watchlist",
                'description'    => "We will not be able to verify this task, but we would appreciate if you add WorkQuest to your Watchlist on CoinMarketCap. simply click Get Ticket button below to get your ticket.",
                'difficulty'      => 'instant',
                'link'           => "https://coinmarketcap.com/currencies/workquest/",
                'tickets'        => 1,
                'input_required' => false,
                'input_title'    => false
            ],[
                'round_id'       => 1,
                'title'          => "Join WorkQuest's Official Telegram Group",
                'description'    => "Please join WorkQuest's Telegram Group.",
                'difficulty'      => 'easy',
                'link'           => 'https://t.me/WorkQuestChat',
                'tickets'        => 1,
                'input_required' => true,
                'input_title'    => 'Your Telegram Username'
            ],[
                'round_id'       => 1,
                'title'          => "Join WorkQuest's official Telegram channel",
                'description'    => "Please join WorkQuest's Telegram Channel.",
                'difficulty'      => 'instant',
                'link'           => 'https://t.me/WorkQuest',
                'tickets'        => 1,
                'input_required' => true,
                'input_title'    => 'Your Telegram Username'
            ],[
                'round_id'       => 1,
                'title'          => "Join WorkQuest's Discord server",
                'description'    => "Please join WorkQuest's Discord Channel.",
                'difficulty'      => 'instant',
                'link'           => 'https://discord.com/invite/U8k234ArHP',
                'tickets'        => 1,
                'input_required' => true,
                'input_title'    => 'Your Discord Username'
            ],[
                'round_id'       => 1,
                'title'          => "Follow WorkQuest on Twitter",
                'description'    => "Please click the link below and Follow WorkQuest on Twitter. Then enter your username and submit the form.",
                'difficulty'      => 'instant',
                'link'           => 'https://twitter.com/workquest_co',
                'tickets'        => 1,
                'input_required' => true,
                'input_title'    => 'Your Twitter Username'
            ],[
                'round_id'       => 1,
                'title'          => "Retweet, Like and Comment on the pinned tweet",
                'description'    => "Like, comment and Retweet the pinned tweet on WorkQuest's official twitter page",
                'difficulty'      => 'normal',
                'link'           => 'https://twitter.com/workquest_co',
                'tickets'        => 3,
                'input_required' => true,
                'input_title'    => 'Retweet Link'
            ],[
                'round_id'       => 1,
                'title'          => "Subscribe to WorkQuest's official YouTube channel",
                'description'    => "Please Subscribe to WorkQuest's official YouTube channel",
                'difficulty'      => 'instant',
                'link'           => 'https://www.youtube.com/channel/UCpQTdOMynXejrRTVf4ksKPA/videos',
                'tickets'        => 1,
                'input_required' => false,
                'input_title'    => null
            ],[
                'round_id'       => 1,
                'title'          => "Follow WorkQuest's official Medium Page",
                'description'    => "Please follow WorkQuest's official Medium page",
                'difficulty'      => 'instant',
                'link'           => 'https://workquest.medium.com/',
                'tickets'        => 1,
                'input_required' => false,
                'input_title'    => null
            ],[
                'round_id'       => 1,
                'title'          => "Join WorkQuest's official Reddit Page",
                'description'    => "Please join WorkQuest's official Reddit Page",
                'difficulty'      => 'instant',
                'link'           => 'https://www.reddit.com/user/WorkQuest_co',
                'tickets'        => 1,
                'input_required' => false,
                'input_title'    => null
            ],
        ]);
    }
}
