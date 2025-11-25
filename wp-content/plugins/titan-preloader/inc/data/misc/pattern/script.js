'use strict';

const titan_create_pattern_item = (type) => {
    const div = document.createElement('div');
    div.className = 'gfx_preloader--pattern-item';

    if (type == 'plus') {
        div.innerText = '+';
    } else if (type == 'cross') {
        const el = document.createElement('div');
        el.className = 'gfx_preloader--pattern-item-cross';
        el.innerHTML =
            '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M13.46,12L19,17.54V19H17.54L12,13.46L6.46,19H5V17.54L10.54,12L5,6.46V5H6.46L12,10.54L17.54,5H19V6.46L13.46,12Z" /></svg>';
        div.appendChild(el);
    } else if (type == 'circular') {
        const el = document.createElement('div');
        el.className = 'gfx_preloader--pattern-item-circular';
        div.appendChild(el);
    } else if (type == 'circular-hollow') {
        const el = document.createElement('div');
        el.className = 'gfx_preloader--pattern-item-circular-hollow';
        div.appendChild(el);
    }

    return div;
};

(() => {
    const parent = document.querySelector('.gfx_preloader--pattern');

    const type = parent.dataset.type;
    const rows = parseInt(parent.dataset.rows);
    const cols = parseInt(parent.dataset.columns);

    for (let i = 0; i < rows; i++) {
        const row_parent = document.createElement('div');
        row_parent.className = 'gfx_preloader--pattern-row';
        for (let j = 0; j < cols; j++) {
            row_parent.appendChild(titan_create_pattern_item(type));
        }
        parent.appendChild(row_parent);
    }
})();
