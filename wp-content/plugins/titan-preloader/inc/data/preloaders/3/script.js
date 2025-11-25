'use strict';

// __PAGE_TRANSITION_START__

// runs when the page is unloaded
const titan_outro = (href) => {
    const tl = titanGsap.timeline({
        onComplete: fire_outro_complete,
        onCompleteParams: [href],
    });

    const progress_bar = document.querySelector('.gfx_preloader--progress:not(.gfx-progress-bar-disabled) .gfx_preloader--progress-bar');
    if (progress_bar != null) {
        tl.to(progress_bar, {
            width: 0,
        });
    }

    tl.titanOutro('.gfx_preloader');
};

// __PAGE_TRANSITION_END__

// runs when the page is loaded
const titan_intro = () => {
    const tl = titanGsap.timeline();

    const progress_bar = document.querySelector('.gfx_preloader--progress:not(.gfx-progress-bar-disabled) .gfx_preloader--progress-bar');
    if (progress_bar != null) {
        tl.to(progress_bar, {
            x: 0,
            duration: 1,
            ease: 'power4.inOut',
        });
    }

    tl.to(
        '.gfx_preloader--counter',
        {
            innerText: '100%',
            snap: 'innerText',
            duration: 1,
        },
        '<'
    );

    tl.titanIntro('.gfx_preloader');
};

// handles the load event
const titan_load_event = () => {
    const event = new CustomEvent('titan-intro-complete');
    window.dispatchEvent(event);
};

(() => {
    const tl = titanGsap.timeline({
        onComplete: () => {
            if (document.readyState === 'complete')
                setTimeout(titan_load_event, 500);
            else window.addEventListener('load', titan_load_event);
        },
    });

    const progress_bar = document.querySelector('.gfx_preloader--progress:not(.gfx-progress-bar-disabled) .gfx_preloader--progress-bar');
    if (progress_bar != null) {
        tl.to(progress_bar, {
            x: '-70%',
            duration: 1,
            ease: 'power4.inOut',
        });
    }

    tl.to(
        '.gfx_preloader--counter',
        {
            innerText: '30%',
            snap: 'innerText',
            duration: 1,
        },
        '<'
    );
})();

(() => {
    titanGsap.to('.gfx_preloader--logo.gfx-rotate', {
        '--test': '360deg',
        repeat: -1,
        duration: 10,
    });
})();
