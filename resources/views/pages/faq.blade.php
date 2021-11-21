@extends('layouts.pages', ['pg' => 'pages'])

@section('content')
    @include('pages.includes._nav')

    <div class="container">
        <section class="my-5 py-2">
            <h2 class="text-center"><strong>Frequently</strong> Asked Questions</h2>
        </section>

        <section class="my-5 py-2">
            <div class="question">
                <strong>How do I participate in the Airdrop?</strong>
                <p>You will be participated in each Airdrop when you have at least 1 ticket.<br>Earn free Airdrop tickets for each round by doing various tasks, just Signup and complete the tasks in your Account.</p>
            </div>
            <div class="question">
                <strong>How do I sign up?</strong>
                <p>Just click the <a href="{{ route('signup') }}">Signup</a> button, and make sure to enter your correct BSC (Binance Smart Chain) wallet address<br><span style="color:red">IMPORTANT: </span>Changing your wallet address is not possible after signing up.</p>
            </div>
			<div class="question">
                <strong>Will I always win?</strong>
                <p>No, but by completing more tasks you will increase your chance of winning on each AirDrop round. Keep in mind that if you participate in all rounds, you will have a separate chance to win each round! (but only once each round)</p>
            </div>
            <div class="question">
                <strong>How many people will win each round?</strong>
                <p>Please refer to our <a href="https://workquest.medium.com/workquest-three-giveaway-programs-a94c30a0a84e" target="_blank">Medium Post</a>.</p>
            </div>
            <div class="question">
                <strong>The timer has reached zero but it restarted afterwards, why is that?</strong>
                <p>We have multiple (currently 4) rounds of AirDrop, so when a round is finished, another starts shortly after and resets the timer. If you have won in a round, your rewards will be safe and recorded, and will be distributed to you on 19th December, 2021.</p>
            </div>
            <div class="question">
                <strong>Can I join in multiple rounds?</strong>
                <p>Sure, each user can do various tasks on each round. The users that joins on first round will have more chance of winning, but even if you join on round 4, you'll have a chance to win!</p>
            </div>
            <div class="question">
                <strong>Is this safe?</strong>
                <p>Yes! we will NEVER ask you to connect your wallet, and even entering your e-mail address is optional! If you are still hesitant, you can simply join by entering a new BSC wallet address with no funds in it.</p>
            </div>
            <div class="question">
                <strong>How will I receive my WorkQuest tokens if I win?</strong>
                <p>We will send the tokens to the address you have signed up with, we will never accept to send them to another address, so please make sure to sign up with your correct BSC address.</p>
            </div>
            <div class="question">
                <strong>How long will it take to announce the winners?</strong>
                <p>We will need 24 hours after each round to pick the winners, but please note that the rewards will be distributed on <span class="text-danger fw-bold">19th December, 2021</span>. So please be patient.</p>
            </div>
            <div class="question">
                <strong>How long will it take to distribute the amounts to winners?</strong>
                <p>All rewards will be distributed on 19th December, 2021. So please be patient.</p>
            </div>
            <div class="question">
                <strong>Why are my completed tasks pending approval?</strong>
                <p>Please allow the system up to 12-24 hours (usually much faster, depending on queued tasks) to approve them. please be patient.</p>
            </div>
            <div class="question">
                <strong>How many times can I win?</strong>
                <p>If you participate in all rounds and complete the tasks for all rounds, you will have a chance to win up to 4 times during 4 rounds (if 1 of your tickets have winning number on that round), but you can <span class="fw-bold">only win once each round</span>.<br>And if you only join on the last round (round 4) you will have a chance to win 1 time.</p>
            </div>
            <div class="question">
                <strong>How do I know if the AirDrop system is fair?</strong>
                <p>We are using a fair draw method, please <a href="{{ route('pages.fair_draw') }}">Click Here</a> to read more.</p>
            </div>
            <div class="question">
                <strong>What else should I know?</strong>
                <p>It is important to know that we will <span style='color:darkred;font-weight:bold;'>NEVER</span> message you on Telegram, Twitter, or any other social media platform. We will also never ask you to connect your Wallet, or send ANY AMOUNT under any circumstances! So please stay safe from scammers.</p>
            </div>
        </section>
    </div>

    @include('pages.includes._footer')
@endsection