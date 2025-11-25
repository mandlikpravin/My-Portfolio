'use strict';

(() => {
    const el = document.querySelector('.gfx_preloader--numbers');
    const parent = document.querySelector('.gfx_preloader--numbers-wrapper');
    if (parent == null) return;
    parent.style.height =
        el.firstElementChild.firstElementChild.offsetHeight + 'px';
})();

// __PAGE_TRANSITION_START__

// runs when the page is unloaded
const titan_outro = (href) => {
    const tl = titanGsap.timeline({
        defaults: {
            ease: 'power4.inOut',
        },
        onComplete: fire_outro_complete,
        onCompleteParams: [href],
    });

    tl.titanOutro('.gfx_preloader');

    tl.to('.gfx_preloader--numbers-inner', {
        yPercent: 0,
        stagger: 0.1,
        duration: 1.5,
    });

    tl.to(
        '.gfx_preloader--percent',
        {
            autoAlpha: 1,
        },
        '<'
    );
};

// __PAGE_TRANSITION_END__

// runs when the page is loaded
const titan_intro = () => {
    const tl = titanGsap.timeline({
        defaults: {
            ease: 'power4.inOut',
        },
    });

    let el = document.querySelector('.gfx_preloader--number');
    if (el == null) return;
    let percent = (el.offsetHeight / (el.offsetHeight * 10)) * 100; // ( element height / total height ) * 100

    tl.to('.gfx_preloader--numbers-inner', {
        yPercent: -100 + percent,
        stagger: 0.1,
        duration: 2,
        onComplete: () => {
            if (typeof titan_progress_complete_anim == 'undefined') return;
            titan_progress_complete_anim();
        },
    });

    tl.to('.gfx_preloader--numbers-inner', {
        yPercent: -100,
        stagger: 0.1,
    });

    tl.to(
        '.gfx_preloader--percent',
        {
            autoAlpha: 0,
        },
        '<'
    );

    tl.titanIntro('.gfx_preloader', null, '<+=.3');
};

(() => {
    if (typeof titan_progress_start_anim == 'undefined') return;
    titan_progress_start_anim();
})();

window.addEventListener('load', () => {
    const event = new CustomEvent('titan-intro-complete');
    window.dispatchEvent(event);
});
