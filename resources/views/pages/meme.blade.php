@extends('layouts.pages', ['pg' => 'pages'])

@section('head')
    <style>
        #memeTab .nav-link{
            color: #405575;
        }
        #memeTab .nav-link:hover{
            border-bottom: 0;
        }
        #memeTab .nav-link.active{
            border-top: 3px solid #BBB !important;
            font-weight: bold;
        }
        #evaluation .evcol{
            padding: 20px 30px;
            border-radius: 5px;
        }
        #evaluation .evcol ul {
            padding-left: 15px;
            list-style: none;
        }
        #evaluation .evcol ul li.ev:before {
            content: "\2022";
            font-weight: bold;
            display: inline-block;
            width: 1em;
            color: #5c636a;
        }
        #evaluation .evcol ul li:first-child{
            font-weight: bold;
            color: #5f77a0;
        }
        ul.list-style-none {
            list-style: none;
            padding-left: 15px;
        }
        ul.list-style-none li, ul.extra-lh li{
            line-height: 2rem;
        }

        #telegram_guide img, #twitter_guide img, #gifs_guide img {
            display: block;
            max-width: 300px;
            border: 1px solid #CCC;
            border-radius: 4px;
            margin: 20px auto;
        }

        .text-attach {
            white-space: pre-wrap;
            margin: 20px 0;
            padding: 15px;
            border: 2px solid #CCC;
            border-radius: 5px;
            background: #F1F1F1;
        }
    </style>
@endsection

@section('content')
    @include('pages.includes._nav')

    <div class="container">
        <section class="my-5 py-2">
            <h2 class="text-center"><strong class="text-info">Meme</strong> Contest @if($guide) : {{ ucwords(str_replace('_',' ', str_replace('gifs','GIFs &',$guide))) }} Guide @endif</h2>
            <h6 class="text-center">🎁 &nbsp; WorkQuest Weekly Meme Contest (looking for 54 winners): Unleash your Meme Game!</h6>
        </section>

        <section class="my-5 py-2">
            <ul class="nav nav-tabs" id="memeTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a href="{{ route('pages.meme') }}" class="nav-link @if( ! $guide) active @endif " id="details-tab">Details</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a href="{{ route('pages.meme.guide', 'telegram') }}" class="nav-link @if($guide === 'telegram') active @endif " id="telegram-tab">Telegram Guide</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a href="{{ route('pages.meme.guide', 'twitter') }}" class="nav-link @if($guide === 'twitter') active @endif " id="twitter-tab">Twitter Guide</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a href="{{ route('pages.meme.guide', 'gifs_videos') }}" class="nav-link @if($guide === 'gifs_videos') active @endif " id="gifs-tab">GIFs &amp; Videos Guide</a>
                </li>
            </ul>
            <div style="background:#FFF;" class="tab-content p-3 border-1 border-top-0 border" id="memeTabContent">
                <div class="tab-pane fade show active py-2" role="tabpanel">
                    @if( ! $guide)
                        <h4 class="text-center mb-4 alert alert-secondary">Create Memes for WorkQuest and win amazing rewards!</h4>
                        <div class="row">
                            <div class="col-md-6">
                                <h6>Rewards &amp; Winners</h6>
                                <table class="table table-bordered border-5 border-secondary">
                                    <tr>
                                        <td style="background:#f2f2f2;">Total Rewards</td>
                                        <th>19,500 WQT</th>
                                    </tr>
                                    <tr>
                                        <td style="background:#f2f2f2;">Weekly Rewards</td>
                                        <th>Total of 2,100 WQT Every Week<br>700 WQT Per Category<br><small class="fw-normal">(5 weeks with 9 winners every week)</small></th>
                                    </tr>
                                    <tr>
                                        <td style="background:#f2f2f2;">Final Winners</td>
                                        <th>9,000 WQT<br><small class="fw-normal">(9 final winners, 500 to 1,500 WQT for each final winner)</small></th>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <h6>Dates</h6>
                                <table class="table table-bordered border-5 border-secondary">
                                    <tr>
                                        <td style="background:#f2f2f2;">Start Date</td>
                                        <th>24 Nov. 2021</th>
                                    </tr>
                                    <tr>
                                        <td style="background:#f2f2f2;">End Date</td>
                                        <th>26 Dec. 2021</th>
                                    </tr>
                                    <tr>
                                        <td style="background:#f2f2f2;">Weekly Rounds</td>
                                        <th>Every Monday winners will be picked!</th>
                                    </tr>
                                    <tr>
                                        <td style="background:#f2f2f2;">Distribution Date for weekly rounds</td>
                                        <th>48 hrs after every round!</th>
                                    </tr>
                                    <tr>
                                        <td style="background:#f2f2f2;">Distribution Date for Final winners</td>
                                        <th>28 Dec. 2021</th>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 my-3">
                                Every Monday (for 5 Weeks) winners will be picked!<br>
                                In the end (27 Dec. 2021), we will pick three winners on each category from best of the bests!
                            </div>
                        </div>
                        <div class="row my-4 mb-5">
                            <div class="col-md-6 px-lg-5">
                                <h5 class="mb-3">A. Weekly Program:</h5>
                                <ul class="list-style-none">
                                    <li>🏆 &nbsp; 1st Place <strong>of each category</strong> (1 winner): 400 WQT</li>
                                    <li>🏆 &nbsp; 2nd Place <strong>of each category</strong> (1 winner): 200 WQT</li>
                                    <li>🏆 &nbsp; 3rd Place <strong>of each category</strong> (1 winner) : 100 WQT</li>
                                </ul>
                            </div>
                            <div class="col-md-6 px-lg-5 mt-4 mt-md-0">
                                <h5 class="mb-3">B. Final Winners:</h5>
                                <ul class="list-style-none">
                                    <li>🏆 &nbsp; 1st Place <strong>of each category</strong> (1 winner): 1,500 WQT</li>
                                    <li>🏆 &nbsp;  2nd Place <strong>of each category</strong> (1 winner): 1,000 WQT</li>
                                    <li>🏆 &nbsp;  3rd Place <strong>of each category</strong> (1 winner) : 500 WQT</li>
                                </ul>
                            </div>
                        </div>
                        <hr>
                        <div class="row my-4" id="evaluation">
                            <h4 class="mb-3 my-3 text-center">🎯 Evaluation Criteria &amp; Guides</h4>
                            <div class="evcol col-lg-4">
                                <h5>1. Best of Twitter Memes<br></h5>
                                <ul class="extra-lh">
                                    <li>Automatic selection</li>
                                    <li class="ev">Each Retweet: +3 Points</li>
                                    <li class="ev">Each Reply: +2 Points</li>
                                    <li class="ev">Each Like: +1 Point</li>
                                </ul>
                                <a href="{{ route('pages.meme.guide', 'twitter') }}" class="btn btn-sm btn-primary">Twitter Guide</a>
                            </div>
                            <div class="evcol col-lg-4 mt-4 mt-lg-0">
                                <h5>2. Best of Telegram Memes<br></h5>
                                <ul class="extra-lh">
                                    <li>Automatic selection</li>
                                    <li class="ev">Based on higher likes</li>
                                </ul>
                                <a href="{{ route('pages.meme.guide', 'telegram') }}" class="btn btn-sm btn-primary">Telegram Guide</a>
                            </div>
                            <div class="evcol col-lg-4 mt-4 mt-lg-0">
                                <h5>3. Best Of GIFs &amp; Video Clip Memes<br></h5>
                                <ul class="extra-lh">
                                    <li>Manual selection</li>
                                    <li class="ev">Selected by WorkQuest’s Team (top three)</li>
                                </ul>
                                <a href="{{ route('pages.meme.guide', 'gifs_videos') }}" class="btn btn-sm btn-primary">GIFs &amp; Videos Guide</a>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-12">
                                <h4 class="mb-3 my-3 text-center">General Rules</h4>
                                <ul class="extra-lh">
                                    <li>All Participants are committed to abide by the rules of the competition. They can use their own design only!</li>
                                    <li>All Participants can only share their meme with friends and in authorized groups.</li>
                                    <li>All Participants (for all 3 programs) can only share their meme once per day in WorkQuest's telegram group. (forwarded from telegram bot (using @like bot), sharing twitter link, or their GIFs or video clips).</li>
                                    <li>Each account (telegram & twitter) can only win once in the entire contest, but they can continue to reach the final round to win the big prize!</li>
                                    <li>Minimum Likes / Retweets must be at least 30 to be accepted in the event.</li>
                                    <li>Each meme has to be published at least 3 days before end of the week, and has to be posted in official telegram group for at least 3 days.</li>
                                </ul>
                            </div>
                        </div>
                        <hr>
                        <div class="row mb-3">
                            <div class="col-12">
                                <h4 class="mb-3 my-3 text-center">🛡 WorkQuest Disclaimer</h4>
                                This is an unofficial program and the WorkQuest team cannot monitor all activities. But participants are committed to never send their designs to groups where posting such content is not allowed. If anyone sees any violations, please report them to our TG admins. If violation is confirmed the participant will be eliminated from the competition.
                                WorkQuest Telegram Group: <a href="https://t.me/WorkQuestChat" target="_blank">@WorkQuestChat</a>
                            </div>
                        </div>
                    @elseif($guide === 'telegram')
                        <h4 class="text-center mb-4 alert alert-secondary">Telegram Guide</h4>
                        <div id="telegram_guide">
                            <h5>Step 1:</h5>
                            Create a nice <a href="https://www.google.com/search?q=what+is+a+meme" target="_blank">Meme</a> for WorkQuest (the text and design are your choice!)
                            <h5 class="mt-4">Step 2:</h5>
                            Message <a href="https://t.me/like" target="_blank">@like</a> bot on Telegram and click Start (this method is used for round 1 and it may change for next rounds)
                            <img src="{{ asset('assets/meme/telegram1.jpg') }}">
                            <h5 class="mt-4">Step 3:</h5>
                            Send your meme image to the bot and <strong>attach the following message to it (exactly the same, just set your telegram username)</strong>:<br>
                            <div class="text-attach">💎 WorkQuest is a global end-to-end jobs marketplace powered by DeFi connecting employees with employers all around the world.
Telegram Group for more info: @WorkQuestChat

🏆 WorkQuest weekly Meme contest.

📽 Next Contest Program: Creating WorkQuest-related content on YouTube & Twitter (announcement coming soon)

$WQT #DeFiJobs #Decentralized #DAO

💫⚡️💫⚡️💫⚡️💫

I've decided to introduce #WorkQuest to the cryptocurrency communities with a meme design.

💫 I am committed to abide by the rules of the competition. I will send my design only to authorized friends and groups and only share my own creations.

🆔 Designer: <strong class="text-danger">@…………… (Participating Telegram ID)</strong>

If you like my Meme, please click the like button below:</div>
                            <strong>Important: please make sure to set your telegram username in the post, as seen in the image below.</strong>
                            <img src="{{ asset('assets/meme/telegram2.jpg') }}">
                            <h5 class="mt-4">Step 4:</h5>
                            When the Bot asks you to select your emoticon, Select the heart icon from emoticon menu:
                            <img src="{{ asset('assets/meme/telegram3.jpg') }}">
                            <h5 class="mt-4">Step 5:</h5>
                            Now you can click Publish to send it to your friends and authorized groups. (Note that if you spam unauthorized groups or people you will be eliminated from the contest)
                            <h5 class="mt-4">Step 6:</h5>
                            After clicking publish and selecting a friend or group chat, make sure to click your Meme image to send it in the correct format:
                            <img src="{{ asset('assets/meme/telegram4.jpg') }}">
                            <br>
                            And now you are done!<br>
                            <strong>Please don't forget to send it to WorkQuest's telegram group as well (but only once per day).</strong>
                            <h5 class="mt-4">Final Example:</h5>
                            <img src="{{ asset('assets/meme/telegram_sample.png') }}">
                        </div>
                    @elseif($guide === 'twitter')
                        <h4 class="text-center mb-4 alert alert-secondary">Twitter Guide</h4>
                        <div id="twitter_guide">
                            <h5>Step 1:</h5>
                            Create a nice <a href="https://www.google.com/search?q=what+is+a+meme" target="_blank">Meme</a> for WorkQuest (the text and design are your choice!)
                            <h5 class="mt-4">Step 2:</h5>
                            When submitting your meme image on twitter, please attach this text (exactly the same) to your meme tweet:<br><strong>(image is sample, replace it with your own meme)</strong>

                            <img src="{{ asset('assets/meme/meme.jpg') }}">
                            <div class="text-attach">🚀 I've decided to introduce #WorkQuest (global end-to-end #jobs marketplace) to the cryptocurrency communities with a meme design.

🏆 weekly #Meme #Contest

If you like my Meme, please: Retweet, Like & Reply

💎 $WQT #WQT #DeFiJobs #Decentralized #DAO #CryptoCurrency #BscGem</div>
                            <h5 class="mt-4">Step 3:</h5>
                            Submit your tweet, try to get as much likes and retweets as possible to win!<br><br>
                            And now you are done!<br>
                            <strong>Please don't forget to send it to WorkQuest's telegram group as well (but only once per day).</strong>
                            <h5 class="mt-4">Final Example:</h5>
                            <img src="{{ asset('assets/meme/twitter_sample.jpg') }}">
                        </div>
                    @elseif($guide === 'gifs_videos')
                        <h4 class="text-center mb-4 alert alert-secondary">GIFs &amp; Videos Guide</h4>
                        <div id="gifs_guide">
                            <h5>Step 1:</h5>
                            Create a nice <a href="https://www.google.com/search?q=what+is+a+meme" target="_blank">Meme</a> for WorkQuest (the text and design are your choice!)
                            <h5 class="mt-4">Step 2:</h5>
                            💫 Attach this text (exactly the same) to your meme (GIFs & video clips) and send it to <a href="https://t.me/WorkQuestChat" target="_blank">our telegram group</a> only once per day:<br><strong>(image is sample, replace it with your own meme)</strong>
                            <img src="{{ asset('assets/meme/meme.jpg') }}">
                            <div class="text-attach">🚀 I've decided to introduce #WorkQuest (global end-to-end #jobs marketplace) to the cryptocurrency communities with a meme design.</div>
                            <br>
                            And now you are done!<br>
                            <strong>Please don't forget to send it to WorkQuest's telegram group as well (but only once per day).</strong>
                            <h5 class="mt-4">Final Example:</h5>
                            <img src="{{ asset('assets/meme/gifs_sample.png') }}">
                        </div>
                    @endif
                </div>
            </div>
        </section>
    </div>

    @include('pages.includes._footer')
@endsection