'use strict';

(() => {
    const parent = document.querySelector('.gfx_preloader--bg');
    if (parent == null) return;
    const hex = parent.dataset.color;
    if (hex == '') return;
    let r = parseInt(hex.slice(1, 3), 16),
        g = parseInt(hex.slice(3, 5), 16),
        b = parseInt(hex.slice(5, 7), 16);

    document
        .querySelector(':root')
        .style.setProperty('--gfx-titan-preloader-3', `${r}, ${g}, ${b}`);
})();

// __PAGE_TRANSITION_START__

// runs when the page is unloaded
const titan_outro = (href) => {
    titanGsap.set('.gfx_preloader', { display: 'flex' });
    titanGsap.set('.gfx_preloader--bg', { yPercent: 200 });

    const tl = titanGsap.timeline({
        onComplete: fire_outro_complete,
        onCompleteParams: [href],
    });

    tl.to('.gfx_preloader--bg', {
        yPercent: 0,
        duration: 1,
    });
};

// __PAGE_TRANSITION_END__

// runs when the page is loaded
const titan_intro = () => {
    const tl = titanGsap.timeline({
        defaults: {
            duration: 1,
        },
        onStart: () => {
            if (typeof titan_progress_complete_anim != 'undefined')
                titan_progress_complete_anim();
        },
        onComplete: () => {
            titanGsap.set('.gfx_preloader', { display: 'none' });
        },
    });

    tl.to('.gfx_preloader--span-inner', {
        yPercent: -100,
        opacity: 0,
        stagger: -0.05,
        ease: 'Expo.easeIn',
    });

    tl.to(
        '.gfx_preloader--bg',
        {
            yPercent: -200,
        },
        '-=.1'
    );
};

// handles the load event
const titan_load_event = () => {
    const event = new CustomEvent('titan-intro-complete');
    window.dispatchEvent(event);
};

// executes immediately
(() => {
    // split the text into pieces and add to DOM
    const text_el = document.querySelector('.gfx_preloader--text');
    if (text_el == null) return;
    text_el.dataset.content.split(' ').forEach((element) => {
        if (element == '') return;
        text_el.innerHTML += `<span class="gfx_preloader--span">
            <span class="gfx_preloader--span-inner">${element}</span>
        </span>`;
    });

    titanGsap.to('.gfx_preloader--span-inner', {
        y: 0,
        opacity: 1,
        stagger: 0.25,
        ease: 'Expo.easeOut',
        duration: 0.75,
        delay: 0.1,
        onComplete: () => {
            if (document.readyState === 'complete')
                setTimeout(titan_load_event, 500);
            else window.addEventListener('load', titan_load_event);
        },
        onStart: () => {
            if (typeof titan_progress_start_anim != 'undefined')
                titan_progress_start_anim();
        },
    });
})();
