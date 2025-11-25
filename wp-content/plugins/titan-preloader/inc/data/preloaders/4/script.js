'use strict';

// __PAGE_TRANSITION_START__

const titan_outro = (href) => {
    const tl = titanGsap.timeline({
        onComplete: fire_outro_complete,
        onCompleteParams: [href],
    });

    tl.titanOutro('.gfx_preloader');
};

// __PAGE_TRANSITION_END__

const titan_intro = () => {
    const tl = titanGsap.timeline();
    tl.titanIntro('.gfx_preloader');
};

window.addEventListener('load', () => {
    const event = new CustomEvent('titan-intro-complete');
    window.dispatchEvent(event);
});
