'use strict';

// __PAGE_TRANSITION_START__

// runs when the page is unloaded
const titan_outro = (href) => {
    const tl = titanGsap.timeline({
        onComplete: fire_outro_complete,
        onCompleteParams: [href],
    });

    tl.set('.gfx_preloader--progress-actual', {
        x: '-100%',
    });

    tl.set('.gfx_preloader--percent', {
        innerText: '0%',
    });

    tl.titanOutro('.gfx_preloader');
};

// __PAGE_TRANSITION_END__

// runs when the page is loaded
const titan_intro = () => {
    const tl = titanGsap.timeline();

    tl.to('.gfx_preloader--progress-actual', {
        x: '-60%',
    });

    tl.to(
        '.gfx_preloader--percent',
        {
            innerText: '40%',
            snap: 'innerText',
        },
        '0'
    );

    tl.to('.gfx_preloader--progress-actual', {
        x: '-40%',
    });

    tl.to(
        '.gfx_preloader--percent',
        {
            innerText: '60%',
            snap: 'innerText',
        },
        '<'
    );

    tl.to(
        '.gfx_preloader--progress-actual',
        {
            x: 0,
        },
        '<+=.25'
    );

    tl.to(
        '.gfx_preloader--percent',
        {
            innerText: '100%',
            snap: 'innerText',
        },
        '<'
    );

    tl.titanIntro('.gfx_preloader');
};

(() => {
    const tl = titanGsap.timeline();

    tl.to('.gfx_preloader--progress-actual', {
        x: '-80%',
    });

    tl.to(
        '.gfx_preloader--percent',
        {
            innerText: '20%',
            snap: 'innerText',
        },
        '0'
    );
})();

window.addEventListener('load', () => {
    const event = new CustomEvent('titan-intro-complete');
    window.dispatchEvent(event);
});
