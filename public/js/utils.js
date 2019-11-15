// Validates with [jshint]
/* jshint esversion: 6 */

// Escape text for HTML
export function escapeHtml(text) {
    if (text === undefined || text === null || typeof text === 'number') {
        return text;
    }
    return String(text)
        .replace(/&/g, '&amp;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#039;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;');
}


// This is a Tagged Template Literal function that escapes values for HTML.
// Use it like this [render``] and not [render(``)].
export function render(strings, ...values) {
    const html = [strings[0]];
    for (let n = 0, m = values.length; n < m; n++) {
        html.push(escapeHtml(values[n]));
        html.push(strings[n+1]);
    }
    return html.join('');
}
