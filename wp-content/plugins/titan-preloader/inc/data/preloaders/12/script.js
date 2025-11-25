'use strict';

// __PAGE_TRANSITION_START__

// runs when the page is unloaded
const titan_outro = (href) => {
    const tl = titanGsap.timeline({
        onComplete: fire_outro_complete,
        onCompleteParams: [href],
    });

    tl.to('.gfx_preloader--box', {
        width: '100vw',
        height: '100vh',
    });

    tl.set(['.gfx_preloader'], {
        display: 'block',
    });

    tl.titanOutro('.gfx_preloader');
};

// __PAGE_TRANSITION_END__

(() => {
    const repeaters = document.querySelectorAll('.gfx_preloader--text');
    repeaters.forEach((repeater) => {
        titanGsap.set(repeater, { width: 'auto' });
        let width = repeater.offsetWidth;
        if (width >= window.innerWidth) {
            titanGsap.set(repeater, {
                width: 0,
                'white-space': 'normal',
                'line-height': '+=15',
            });
        } else {
            titanGsap.set(repeater, { width: 0 });
        }
    });
})();

// runs when the page is loaded
const titan_intro = () => {
    const tl = titanGsap.timeline({
        onComplete: () => {
            titanGsap.set('.gfx_preloader', {
                display: 'none',
            });
        },
    });
    const repeaters = document.querySelectorAll('.gfx_preloader--text');

    tl.to('.gfx_preloader--box', {
        width: '1vw',
        height: '1vw',
        duration: 0.5,
        onComplete: () => {
            if (typeof titan_progress_start_anim == 'undefined') return;
            titan_progress_start_anim();
        },
    });

    repeaters.forEach((repeater, index) => {
        tl.to(repeater, {
            width: 'auto',
            marginRight: 10,
            'clip-path': 'polygon(0 0, 100% 0, 100% 200%, 0% 100%)',
        });

        tl.to(
            '.gfx_preloader--box',
            {
                rotation: 90,
                borderRadius: '50%',
            },
            '<'
        );

        tl.to(
            repeater,
            {
                width: 0,

                marginRight: 0,
                'clip-path': 'polygon(0 0, 0% 0%, 0% 100%, 0% 100%)',
            },
            '>+=1'
        );

        tl.to(
            '.gfx_preloader--box',
            {
                rotation: 0,
                borderRadius: '0',
                onComplete: () => {
                    if (typeof titan_progress_complete_anim == 'undefined')
                        return;
                    if (index != repeaters.length - 1) return;
                    titan_progress_complete_anim();
                },
            },
            '<'
        );
    });

    tl.titanIntro('.gfx_preloader');
};

window.addEventListener('load', () => {
    const event = new CustomEvent('titan-intro-complete');
    window.dispatchEvent(event);
});
