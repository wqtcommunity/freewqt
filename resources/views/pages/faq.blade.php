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
                <p>No, but by completing more tasks you will increase your chance of winning on each AirDrop round.</p>
            </div>
            <div class="question">
                <strong>How many people will win each round?</strong>
                <p>Please refer to AirDrop descriptions for each round (Account Dashboard > Current AirDrop > Description).</p>
            </div>
            <div class="question">
                <strong>How many WorkQuest tokens will be in the AirDrop pool each round?</strong>
                <p>The amount will vary, Please refer to AirDrop descriptions for each round (Account Dashboard > Current AirDrop > Description). Also please note that <span style='font-weight:bold;color:darkgreen;'>the specified airdrop amount in the pool will be split between all winners</span>.</p>
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
                <p>We will need 24 hours to find the winners based on the fair draw method described on <a href="{{ route('pages.fair_draw') }}">this page</a>.</p>
            </div>
            <div class="question">
                <strong>How long will it take to distribute the amounts to winners?</strong>
                <p>Amounts will be sent to winners' BSC wallet addresses a week after "all rounds" end.</p>
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