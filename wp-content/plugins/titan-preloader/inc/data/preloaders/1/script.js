'use strict';

const titan_decrease_counter = (countdown_el) => {
    if (countdown_el == null) return;
    countdown_el.dataset.count = parseInt(countdown_el.dataset.count) - 1;
    countdown_el.innerHTML = countdown_el.dataset.count;
};

// __PAGE_TRANSITION_START__

// runs when the page is unloaded
const titan_outro = (href) => {
    const tl = titanGsap.timeline({
        defaults: {
            ease: Power4.easeOut,
        },
        onComplete: fire_outro_complete,
        onCompleteParams: [href],
    });

    tl.set('.gfx_preloader--countdown', {
        autoAlpha: 0,
    });

    tl.set('.gfx_preloader', {
        display: 'block',
    });

    tl.titanOutro('.gfx_preloader');
};

// __PAGE_TRANSITION_END__

// runs when the page is loaded
const titan_intro = () => {
    const tl = titanGsap.timeline({
        defaults: { duration: 1, ease: 'slow(0.7, 0.7, false)' },
        onComplete: () => {
            titanGsap.set('.gfx_preloader', {
                display: 'none',
            });
        },
    });
    let countdown_el = document.querySelector('.gfx_preloader--countdown');

    tl.to('.gfx_preloader--countdown', {
        scale: 1,
        opacity: 1,
        ease: Power4.easeOut,
    });

    tl.to(
        '.gfx_preloader--bg-1',
        {
            '--progress': '360deg',
            onComplete: titan_decrease_counter,
            onCompleteParams: [countdown_el],
        },
        '<'
    );

    tl.to('.gfx_preloader--bg-2', {
        '--progress': '360deg',
        onComplete: titan_decrease_counter,
        onCompleteParams: [countdown_el],
    });

    tl.to('.gfx_preloader--bg-3', {
        '--progress': '360deg',
        onComplete: titan_decrease_counter,
        onCompleteParams: [countdown_el],
    });

    tl.to('.gfx_preloader--countdown', {
        scale: 1.5,
    });

    tl.to(
        '.gfx_preloader--bg-4',
        {
            '--progress': '360deg',
        },
        '<'
    );

    tl.titanIntro('.gfx_preloader');
};

window.addEventListener('load', () => {
    const event = new CustomEvent('titan-intro-complete');
    window.dispatchEvent(event);
});
