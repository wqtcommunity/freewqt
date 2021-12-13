@if(date('Ymd') < 20220128)
<div class="container-lg text-center">
    <section id="note" class="px-5 py-3 my-4">
        Made with <span class="heart">&hearts;</span> by <a href="https://workquest.co/" target="_blank">WorkQuest</a> fans and supporters.
        <br><br>
        <a class="me-3 btn btn-sm btn-primary" href="{{ route('pages.faq') }}">FAQ</a>
        <a class="me-3 btn btn-sm btn-primary" href="{{ route('pages.fair_draw') }}">Fair Draw</a>
        <a class=" btn btn-sm btn-primary" href="{{ route('login') }}">Account</a>
    </section>
</div>
@endif