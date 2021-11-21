@extends('layouts.pages', ['pg' => 'pages'])

@section('content')
    @include('pages.includes._nav')

    <div class="container">
        <section class="my-5 py-2">
            <h2 class="text-center"><strong class="text-info">Fair</strong> Draw</h2>
        </section>

        <section class="my-5 py-2">
            <div class="question">
                <strong>All our AirDrops use a Fair Draw method!</strong>
                <p>
					For each AirDrop, we will determine an upcoming Block Number on the BSC chain, when that 
					Block is mined, we will take its Hash and use it to pick the winners.
					<br>
					Since there is no way to know the hash of a block that is going to be mined in the future, you can be sure that airdrops on this website are fair!
					<br><br>
					When the specified block is mined, we will use a publicly published method to extract the winning ticket numbers, which can be used by any one to be sure that the draw is fair.
					<br><br>
					When you complete a task, you will earn a Ticket, which is a number generated for you as task completion reward, please note that ticket numbers start to generate from {{ $tickets['mid'] }}, then 1 ticket is above it, and another time it is below it, the increase/decrease is 1 by 1 for each ticket (increase or decrease is determined randomly).
					<br><br>
					Amounts in the AirDrop pool <span style='font-weight:bold;color:darkgreen;'>will be split between all the winners</span> and sent directly to wallet addresses a week after all rounds have ended, so if you win please be patient.
                </p>
            </div>
        </section>
    </div>

    @include('pages.includes._footer')
@endsection