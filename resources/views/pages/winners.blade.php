@extends('layouts.pages', ['pg' => 'pages'])

@section('content')
    @include('pages.includes._nav')

    <div class="container">
        <section class="my-5 py-2">
            <h2 class="text-center">Previous <strong class="text-primary">Winners</strong></h2>
        </section>

        <section class="my-5 py-2">
            <div class="question">
                <strong>Round #1</strong>
                <p>Winners:</p>
            </div>
        </section>
    </div>

    @include('pages.includes._footer')
@endsection