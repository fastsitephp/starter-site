// This page should only be loaded by older browsers
// that don't support <script type="module">.

// Validates with [jshint]
(function() {
    'use strict';
    document.addEventListener('DOMContentLoaded', function() {
        // Show warning element. The text content is initially
        // stored in the attribute [data-content] so that bots
        // which read the page do include it as content text.
        var warning = document.getElementById('old-browser-warning');
        var content = warning.querySelector('[data-content]');
        content.textContent = content.getAttribute('data-content');
        warning.style.display = "";
        
        // Disable buttons
        var buttons = document.querySelectorAll('button');
        Array.prototype.forEach.call(buttons, function(button) {
            button.disabled = true;
        });
    });
})();