'use strict';

// __PAGE_TRANSITION_START__

// runs when the page is unloaded
const titan_outro = (href) => {
    const tl = titanGsap.timeline({
        onComplete: fire_outro_complete,
        onCompleteParams: [href],
        defaults: {  ease: 'power4.inOut', duration: 1 },
    });

    const color = getComputedStyle(document.documentElement).getPropertyValue('--gfx-titan-bg-color');

    // tl.set('.gfx_preloader', {
    //     background: color
    // });

    tl.set('.gfx_preloader', {
        autoAlpha: 1
    });

    tl.set(
        '.gfx_preloader-bar',
        {
            y: '100%',
            // 'clip-path': 'polygon(0 0, 100% 0, 100% 100%, 0% 100%)',
        }
    );

    // tl.set(
    //     '.gfx_preloader-bar-border',
    //     {
    //         backgroundColor: color
    //     }
    // );

    tl.set(
        '.gfx_preloader-counter-inner',
        {
            innerText: '00%',
            y: '0'
        }
    );

    tl.to(
        '.gfx_preloader-bar',
        {
            y: 0,
            stagger: .25
        }
    );

    tl.to('.gfx_preloader-bar-border', {
        autoAlpha: 1,
        // stagger: .25
    });

    tl.to(
        [ '.gfx_preloader-logo', '.gfx_preloader-content', '.gfx_preloader-counter' ],
        {
            autoAlpha: 1
        }
    );

};

// __PAGE_TRANSITION_END__

// runs when the page is loaded
const titan_intro = () => {
    const tl = titanGsap.timeline({ 
        defaults: {  ease: 'power4.inOut', duration: 1 },
        onComplete: () => {
            titanGsap.set('.gfx_preloader', {
                autoAlpha: 0
            });
        }
    });

    tl.to(
        '.gfx_preloader-counter-inner',
        {
            innerText: '33%',
            snap: 'innerText',
        }
    );

    tl.to(
        '.gfx_preloader-counter-inner',
        {
            innerText: '60%',
            snap: 'innerText',
        }
    );

    tl.to(
        '.gfx_preloader-counter-inner',
        {
            innerText: '99%',
            snap: 'innerText',
        }
    );

    // for (let i = 0; i < 3; i++) {
    //     tl.to(
    //         '.gfx_preloader-counter-inner',
    //         {
    //             y: '-100%'
    //         },
    //         i !== 0 ? '>+=.1' : ''
    //     );

    //     tl.set(
    //         '.gfx_preloader-counter-inner',
    //         {
    //             innerText: percentages[i] + '%',
    //             y: '100%'
    //         }
    //     );

    //     tl.to(
    //         '.gfx_preloader-counter-inner',
    //         {
    //             y: '0'
    //         }
    //     );
    // }

    tl.to(
        '.gfx_preloader-counter-inner',
        {
            y: '-100%'
        }
    );

    tl.to(
        [ '.gfx_preloader-logo', '.gfx_preloader-content', '.gfx_preloader-counter' ],
        {
            autoAlpha: 0
        }
    );

    tl.set('.gfx_preloader-bars', { background: 'transparent' });

    tl.to(
        '.gfx_preloader-bar-border',
        {
            autoAlpha: 0
        }
    );

    tl.to(
        '.gfx_preloader-bar',
        {
            y: '100%',
            stagger: .25
            // 'clip-path': 'polygon(100% 0, 100% 0, 100% 100%, 100% 100%)'
        },
        '<'
    );
};

(() => {
    const tl = titanGsap.timeline({ 
        defaults: { duration: 1 }
    });

    // tl.from('.gfx_preloader-bar', {
    //     yPercent: 100,
    //     stagger: .25
    // });

})();

window.addEventListener('load', () => {
    const event = new CustomEvent('titan-intro-complete');
    window.dispatchEvent(event);
});
