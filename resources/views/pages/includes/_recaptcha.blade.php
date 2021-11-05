@if(config('custom.recaptcha.enabled') && isset($page_id) && in_array($page_id, config('custom.recaptcha.enable_pages')))
    <!-- Google Recaptcha -->
    <div class="mt-3 mb-1 g-recaptcha" data-sitekey="{{ config('custom.recaptcha.site_key') }}" data-theme="light"></div>
@endif
