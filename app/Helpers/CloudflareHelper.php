<?php
// If server is behind Cloudflare, set the actual user IP in REMOTE_ADDR
if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
    $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
}