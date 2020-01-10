<!--
    This is a template login page and is designed to work well with both
    regular Websites and Single Page Apps (SPA).

    Login and Password are sent from a JSON service and if validated a Cookie
    will be sent with the response and the page will be reloaded. This method
    allows for the site to handle the user’s requested URL without having to
    handle redirects.

    JavaScript included with this page is designed to work with all browswers
    and is small in size so it's easy to customize for your site.
-->
<div class="container">
    <section class="login-form">
        <h1><?= $app->escape($i18n['page_title']) ?></h1>
        <form method="post" action="../<?= $app->escape($app->lang) ?>/auth/login">
            <div class="form-group">
                <input
                    type="text"
                    id="user"
                    name="user"
                    class="form-control"
                    required
                    placeholder="<?= $app->escape($i18n['enter_login']) ?>"
                    autocomplete="username">
                <p><i>Admin</i></p>
            </div>
            <div class="form-group">
                <input
                    type="password"
                    id="password"
                    name="password"
                    class="form-control"
                    required
                    placeholder="<?= $app->escape($i18n['enter_password']) ?>"
                    autocomplete="current-password">
                <p><i>Password123</i></p>
            </div>
            <button type="submit" class="btn btn-primary" id="btn-submit"><?= $app->escape($i18n['submit']) ?></button>
            <div
                class="col mt-4 alert alert-danger"
                role="alert"
                id="error-text"
                style="display:none;"
                data-default-error="<?= $app->escape($i18n['unexpected_error']) ?>">
            </div>
        </form>
    </section>
</div>
<script>
    // Validates online with both [jshint] and [eslint]
    (function () {
        'use strict'; // Invoke Strict Mode

        // Show Error Message
        function showError(error) {
            var el = document.getElementById('error-text');
            var errorText = el.getAttribute('data-default-error');
            if (error && error.errorMessage) {
                errorText = error.errorMessage; // Display error from server
            } else if (typeof error === 'string') {
                errorText += ' ' + error;
            }
            el.textContent = errorText;
            el.style.display = '';
        }

        // Setup once page is ready
        document.addEventListener('DOMContentLoaded', function () {
            // Get elements
            var btnSubmit = document.getElementById('btn-submit'),
                user = document.getElementById('user'),
                password = document.getElementById('password');

            // Disable submit button if login or password are blank.
            // This only happens when the user edits and not when the page is first loaded.
            // The reason is because Chrome will display the autofill value but will not
            // populate the controls until the page is clicked on. The work around for the
            // issue is to keep the button enabled by default and then if the user clicks
            // submit without filling anything in then the input controls are highlighted
            // in red and the button is disabled until they fill in the info.
            function hasInput() {
                return (user.value.trim() !== '' && password.value.trim() !== '');
            }
            function setFormState(updateBorder) {
                btnSubmit.disabled = !hasInput();
                if (updateBorder === true) {
                    user.style.borderColor = (user.value.trim() === '' ? 'red' : '');
                    password.style.borderColor = (password.value.trim() === '' ? 'red' : '');
                }
            }
            user.oninput = setFormState;
            password.oninput = setFormState;

            // Handle Submit Button Click.
            // If JavaScript is disabled the user would simply see a JSON response,
            // and then if logged in and they refresh they will see the page.
            btnSubmit.onclick = function (e) {
                // Prevent the Form from Submitting
                e.preventDefault();

                // Check for input and exit if not set
                if (!hasInput()) {
                    setFormState(true);
                    return;
                }

                // Get Login Form
                var formData = 'user=' + encodeURIComponent(user.value);
                formData += '&password=' + encodeURIComponent(password.value);

                // Post the Form Data using an XMLHttpRequest Object. XHR is used
                // over [fetch] on the login page so that the template can work with IE
                // and old versions of Mobile Safari (iOS 9 - older iPhones and iPads).
                var http = new XMLHttpRequest();

                // Handle the JSON Response
                http.onload = function () {
                    try {
                        if (http.status >= 200 && http.status < 400) {
                            // Check the result
                            var data = JSON.parse(http.responseText);
                            if (data.success) {
                                // A Valid Login will result in a Coookie being
                                // sent with the response so simply re-load the
                                // page and the requested page will show.
                                window.location.reload(true);
                            } else {
                                showError(data);
                            }
                        } else {
                            showError('Response Status Code: ' + http.status);
                        }
                    } catch (e) {
                        showError('Error: ' + e);
                    }
                };

                // Handle unexpected errors
                http.onerror = function() { showError(); };

                // Submit POST
                http.open('POST', document.querySelector('form').getAttribute('action'), true);
                http.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
                http.send(formData);
            };
        });
    })();
</script>