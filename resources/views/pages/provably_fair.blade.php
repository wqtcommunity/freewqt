@extends('layouts.pages', ['pg' => 'pages'])

@section('content')
    @include('pages.includes._nav')

    <div class="container">
        <section class="my-5 py-2">
            <h2 class="text-center"><strong class="text-info">Provably</strong> Fair</h2>
        </section>

        <section class="my-5 py-2">
            <div class="question">
                <strong>All our AirDrops are Provably Fair!</strong>
                <p>
					For each AirDrop, we will determine an upcoming Block Number on the BSC chain, when that 
					Block is mined, we will take its Hash and use it to pick the winners.
					<br>
					Since there is no way to know the hash of a block that is going to be mined in the future, you can be sure that all of the airdrops on this website are 100% fair!
					<br><br>
					When you complete a task, you will earn a Ticket, which are random letters and numbers generated randomly.
					<br>
					After the specified block is mined, we will compare all tickets to the block hash, and look for similarities, if part of your ticket matches the block hash, you are a winner!
					<br><br>
					For example if your ticket is "a<span style='font-weight:bold;color:green;'>4f8b2fc</span>9e..." and the block hash is "0x0ab2780<span style='font-weight:bold;color:green;'>4f8b2fc</span>2e3cc689...", because part of your ticket (4f8b2fc) matches the Block Hash, you are a winner!
					<br><br>
					In each round, the required number of matched characters to win will be specified. in the example above 7 characters are matched with the block hash, but usually we specify a lower number of characters.
					<br><br>
					Amounts in the AirDrop pool <span style='font-weight:bold;color:darkgreen;'>will be split between all the winners</span> a few days after the end of each round.
				</p>
            </div>
        </section>
    </div>

    @include('pages.includes._footer')
@endsection