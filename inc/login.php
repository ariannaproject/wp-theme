<?php

/**
 * Returns the login URL with a redirect to the current page after login.
 */
function arianna_get_login_url_with_redirect() {
    global $wp;
    return ARIANNA_LOGIN_URL . '?redirect_to=' . urlencode(home_url($wp->request));
}