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
					When the specified block is mined, we will use the following code to generate the winning ticket numbers:
                    <br><br>

                    <code>$block_hash = 'BLOCK_HASH'; // This is specified after the predetermined block number is mined<br><br>

$min_ticket_number = 49850000; // The exact value is defined at the end of each round and will be publicly shared<br>
$max_ticket_number = 50150000; // The exact value is defined at the end of each round and will be publicly shared<br><br>

$total_winners = 500;<br><br>

$block_hash_first_char = substr(str_replace('0x','', $block_hash), 0, 1);<br><br>

$total_tickets = $max_ticket_number - $min_ticket_number;<br>
$step = intval($total_tickets / $total_winners);<br><br>

$hash_number = hexdec($block_hash_first_char) + 1;<br><br>

$multiplier = $step - $hash_number;<br><br>

$n = 0;<br>
$winners = [];<br>
do{<br>
                        &nbsp;&nbsp;&nbsp;$n++;<br>
                        &nbsp;&nbsp;&nbsp;$winner = $min_ticket_number + ($n * $multiplier);<br><br>

                        &nbsp;&nbsp;&nbsp;if($winner <= $max_ticket_number){<br>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$winners[] = $winner;<br>
                        &nbsp;&nbsp;&nbsp;}<br>
}while($winner < $max_ticket_number);<br><br>

print_r($winners);</code>
                    <br><br>
The code above will generate the winning ticket numbers once the block is mined, and you can try it yourself.
                    <br><br>
                    As we have specified before, each user can only win once each round (this will greatly increase the chance of all users to win), the repeating ticket numbers for the same winner will be excluded, and if total winner count gets below 500 for each round, we will pick extra winners on the final round to reach a total of 2000.
                    <br><br>
                    Your tickets for each round will be saved and used for the next rounds as well, but if you complete the tasks for the next rounds, you will have a higher chance of winning.
                    <br><br>
                    <span class="fw-bold">Lottery Winners</span><br><br>
                    First Winner = <code>Smallest Ticket Number + (int) hexdec(First 4 characters of Block Hash) * (Total Tickets / 65535)</code><br>
                    Second Winner = <code>Smallest Ticket Number + (int) hexdec(Next 4 characters of Block Hash) * (Total Tickets / 65535)</code><br>
                    Third Winner = <code>Smallest Ticket Number + (int) hexdec(Next 4 characters of Block Hash) * (Total Tickets / 65535)</code><br>
                </p>
            </div>
        </section>
    </div>

    @include('pages.includes._footer')
@endsection