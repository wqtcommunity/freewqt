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

                    <code>$block_hash = 'BLOCK_HASH'; // This is determined after the predefined block number is mined, for Round 1 the predefined block was 12860740, for current round check your dashboard under Current Round page (see Predefined block number)<br><br>

$min_ticket_number = 49764533; // The exact value is determined at the end of each round. Update: For Round 1 it was 49764533<br>
$max_ticket_number = 50235479; // The exact value is determined at the end of each round. Update: For Round 1 it was 50235479<br><br>

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
                <br>
                <strong>UPDATE (December 13, 2021): Final details to use in the code above:</strong>
                <table class="table table-bordered my-2" style="background:#FFF;">
                    <tr>
                        <th>Round #</th>
                        <th>Predetermined BSC Block (to get Block Hash)</th>
                        <th>Ticket Minimum</th>
                        <th>Ticket Maximum</th>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>12860740</td>
                        <td>49764533</td>
                        <td>50235479</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>13063315</td>
                        <td>49755722</td>
                        <td>50244294</td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>13240482</td>
                        <td>49746867</td>
                        <td>50253232</td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td>13425511</td>
                        <td>49738214</td>
                        <td>50261899</td>
                    </tr>
                </table>
            </div>
        </section>
    </div>

    @include('pages.includes._footer')
@endsection