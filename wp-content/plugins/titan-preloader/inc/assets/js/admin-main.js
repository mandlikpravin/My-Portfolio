'use strict';

(() => {
    /**
     * Problem:
     * Adding a new repeater block causes all the notice fields
     * (e.g. 'transitions settings', 'pattern settings') to disappear.
     * Solution:
     * Set the corresponding notice fields to display: block on click
     */
    (() => {
        document.addEventListener('click', (e) => {
            if (!e.target.matches('.redux-repeaters-add')) return;
            const parent = e.target.closest('.redux-field-container');
            let id = parent.dataset.id;
            if (id == null) return;
            id = parseInt(id);
            const labels = document.querySelectorAll(
                `.redux-notice-field[id^="info-${id}"]`
            );
            if (labels == null || labels.length < 1) return;
            labels.forEach((label) => {
                label.style.setProperty('display', 'block');
            });
        });
    })();

    window.addEventListener('redux-save', (e) => {
        const msg = document.querySelector(e.detail.class);
        if (msg == null) return;
        msg.style.setProperty('opacity', '1');
        msg.style.setProperty('visibility', 'visible');

        setTimeout(() => {
            msg.style.setProperty('opacity', '0');
            msg.style.setProperty('visibility', 'hidden');
        }, 2000);
    });
})();
