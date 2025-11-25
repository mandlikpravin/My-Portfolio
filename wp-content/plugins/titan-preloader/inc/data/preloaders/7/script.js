'use strict';

(() => {
    const bg = document.querySelector('.gfx_preloader--bg');
    const text = document.querySelector('.gfx_preloader--text');
    if (text == null) return;
    let coords = text.getBoundingClientRect();

    titanGsap.set(bg, {
        x: coords.x - coords.width * 1.6,
        y: coords.y,
        width: coords.width * 1.5,
        height: coords.height,
    });
})();

// __PAGE_TRANSITION_START__

// runs when the page is unloaded
const titan_outro = (href) => {
    const tl = titanGsap.timeline({
        onComplete: fire_outro_complete,
        onCompleteParams: [href],
    });

    tl.set(['.gfx_preloader--bg', '.gfx_preloader svg'], {
        opacity: 1,
    });

    tl.set('.gfx_preloader--bg', {
        width: 0,
    });

    tl.titanOutro('.gfx_preloader');
};

// __PAGE_TRANSITION_END__

// runs when the page is loaded
const titan_intro = () => {
    const tl = titanGsap.timeline({});

    tl.to('.gfx_preloader--bg', {
        x: '+=39%',
        duration: 1,
        onStart: () => {
            if (typeof titan_progress_start_anim == 'undefined') return;
            titan_progress_start_anim();
        },
    });

    tl.to('.gfx_preloader--bg', {
        x: '+=59%',
        duration: 1,
        onStart: () => {
            if (typeof titan_progress_complete_anim == 'undefined') return;
            titan_progress_complete_anim();
        },
    });

    tl.titanIntro('.gfx_preloader');
};

window.addEventListener('load', () => {
    const event = new CustomEvent('titan-intro-complete');
    window.dispatchEvent(event);
});
