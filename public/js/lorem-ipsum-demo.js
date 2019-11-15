// Validates with [jshint]
/* jshint esversion: 6 */

import { render } from './utils.js'; 

const btn = document.getElementById('btn-refresh');
btn.onclick = refreshTable;

function refreshTable(e) {
    const url = 'lorem-ipsum/data';
    fetch(url, {
        method: 'GET',
        cache: 'no-store',
    })
    .then(response => {
        return response.json();
    })
    .then(data => {
        renderTable(data.records);
    })
    .catch(error => {
        showError(error);
    });
}

function renderTable(records) {
    // Build and Set HTML
    const html = [];
    for (const record of records) {
        html.push(render`
            <tr>
                <td>${record.text1}</td>
                <td>${record.text2}</td>
                <td>${record.value}</td>
            </tr>`
        );
    }
    document.querySelector('table tbody').innerHTML = html.join('');
}

function showError(error) {
    console.error(error);
    const html = render`<tr><td colspan="3" class="alert alert-danger">${error}</td></tr>`;
    document.querySelector('table tbody').innerHTML = html;
}
