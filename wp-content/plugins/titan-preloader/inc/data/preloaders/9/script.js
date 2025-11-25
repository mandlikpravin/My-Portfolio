'use strict';

const titan_get_ball_size = () => {
    if (window.innerWidth > window.innerHeight) return window.innerWidth * 1.5;
    else return window.innerHeight * 1.5;
};

// __PAGE_TRANSITION_START__

const titan_outro = (href) => {
    let wrapper = document.querySelector('.gfx_preloader');

    let tl = titanGsap.timeline({
        onComplete: (href) => {
            wrapper.bounceTl.play();
            setTimeout(() => {
                fire_outro_complete(href);
            }, 2000);
        },
        onCompleteParams: [href],
    });

    tl.set('.gfx_preloader', {
        display: 'flex',
    });

    tl.set('.gfx_preloader--ball', {
        y: -100,
    });

    tl.titanOutro('.gfx_preloader');

    tl.to(
        '.gfx_preloader--ball',
        {
            width: 60,
            height: 60,
        },
        0
    );
};

// __PAGE_TRANSITION_END__

const titan_intro = () => {
    let wrapper = document.querySelector('.gfx_preloader');
    if (wrapper == null) return;
    wrapper.bounceTl.pause();

    let size = titan_get_ball_size();

    let tl = titanGsap.timeline({
        defaults: {
            duration: 0.75,
        },
        onComplete: () => {
            titanGsap.set('.gfx_preloader', { display: 'none' });
        },
    });

    tl.set('.gfx_preloader--ball', {
        transformOrigin: 'center center',
    });

    tl.to('.gfx_preloader--ball', {
        width: size,
        height: size,

        y: 0,
        scale: 1,
        borderRadius: '50%',
    });

    tl.titanIntro('.gfx_preloader');

    tl.play();
};

(() => {
    let wrapper = document.querySelector('.gfx_preloader');
    if (wrapper == null) return;
    wrapper.bounceTl = titanGsap.timeline({ repeat: -1, yoyo: true });
    wrapper.bounceTl
        .add('start')
        .to('.gfx_preloader--ball', 0.5, {
            y: 100,
            ease: Circ.easeIn,
        })
        .to(
            '.gfx_preloader--ball',
            0.1,
            {
                scaleY: 0.6,
                transformOrigin: 'center bottom',
                borderBottomLeftRadius: '40%',
                borderBottomRightRadius: '40%',
                ease: Circ.easeIn,
            },
            '-=.05'
        )
        .to(
            '.gfx_preloader--shadow',
            0.5,
            {
                scale: 1.5,
                opacity: 0.7,
                ease: Circ.easeIn,
            },
            'start'
        );
    wrapper.bounceTl.play();
})();

window.addEventListener('load', () => {
    const event = new CustomEvent('titan-intro-complete');
    window.dispatchEvent(event);
});
