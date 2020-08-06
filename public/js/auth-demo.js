/**
 * The JavaScript code below provides an example of how to read the Authenticated User
 * from the Cookie. If you are developing an SPA (Single Page App) you may want to
 * copy and modify this code to handle logic based on user roles or specific users
 * from JavaScript.
 *
 * Validates online with both [jshint] and [eslint].
 *
 * This assumes that `$cookie_httponly = false` is set from [app\Middleware\Auth.php].
 * For sites or apps that include untrusted third-party JavaScript code using HttpOnly
 * cookies is often considered more secure against XSS, however CSRF protection is required
 * when using HttpOnly cookies. By default the FastSitePHP Starter Site blocks all
 * third-party code from accessing cookies via JavaScript by using CSP (Content-Security-Policy).
 */
(function() {
    'use strict';

    // Return Cookie value or null
    function getCookie(name) {
        var cookies = document.cookie.split(';');
        for (var n = 0, m = cookies.length; n < m; n++) {
            var cookie = cookies[n].trim();
            if (cookie.indexOf(name + '=') === 0) {
                return cookie.substr(name.length + 1);
            }
        }
        return null;
    }

    // For apps that need Unicode decoding see:
    // https://developer.mozilla.org/en-US/docs/Web/API/WindowBase64/Base64_encoding_and_decoding#The_Unicode_Problem
    function decodeBase64UrlSafe(base64url) {
        var padding = base64url.length % 4;
        if (padding !== 0) {
            padding = 4 - padding;
        }
        var base64 = base64url.replace(/_/g, '/').replace(/-/g, '+');
        if (String.prototype.repeat === undefined) {
            // IE 11 and Old Browsers
            base64 += Array.apply(null, Array(padding)).map(function() { return "=" }).join('');
        } else {
            base64 += '='.repeat(padding);
        }
        return atob(base64);
    }

    // Get User from Cookie if available
    function getUser() {
        var regexJWT = /^[a-zA-Z0-9_-]{2,}\.([a-zA-Z0-9_-]{2,})\.[a-zA-Z0-9_-]{2,}$/,
            regexCSD = /^([a-zA-Z0-9_-]{2,})\.j\.(\d+).[a-zA-Z0-9_-]{2,}$/,
            regexENC = /^[a-zA-Z0-9_-]{2,}$/,
            value = getCookie('user'),
            result,
            user = null,
            expires;

        if (value) {
            if (regexJWT.test(value)) {
                // JWT (JSON Web Token)
                result = value.match(regexJWT);
                user = JSON.parse(decodeBase64UrlSafe(result[1]));
                console.log('Using JWT for User Storage');
            } else if (regexCSD.test(value)) {
                // Signed Cookie
                console.log('Using a Signed Cookie for for User Storage:');
                result = value.match(regexCSD);
                user = JSON.parse(decodeBase64UrlSafe(result[1]));

                // Example of how to read the expired time and if expired
                expires = parseInt(result[2], 10);
                console.log('Expires at:');
                console.log(expires);
                console.log('Expired:');
                console.log(Date.now() > (new Date(expires)));
            } else if (regexENC.test(value)) {
                // Encrypted Cookie
                console.log('Using an Encrypted Cookie, User cannot be viewed from JavaScript:');
                console.log(value);
            } else {
                // Unknown
                console.log('Unknown format for user cookie:');
                console.log(value);
            }
        } else {
            console.log('User cookie not found.');
            if (getCookie('PHPSESSID') !== null) {
                console.log('Using PHP Sessions.');
            }
        }
        return user;
    }

    // Display User from Cookie in the console when the page loads
    document.addEventListener('DOMContentLoaded', function () {
        var user = getUser();
        console.log('User:');
        console.log(user);
    });
})();