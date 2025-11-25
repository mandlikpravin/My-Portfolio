'use strict';

(() => {
    const parent = document.querySelector('.gfx_preloader');
    if (parent == null) return;
    let circular = false;
    if (parent.classList.contains('gfx-circular')) {
        circular = true;
    }

    for (let i = 0; i < 50; i++) {
        const star = document.createElement('div');
        star.className = 'gfx_preloader--star';

        let x = Math.floor(Math.random() * window.innerWidth);
        let width;
        let height;

        if (!circular) {
            width = 1;
            height = Math.random() * 100;
        } else {
            width = height = Math.random() * 25;
        }

        let duration = Math.max(Math.random() * 1, 0.3);

        star.style.left = x + 'px';
        star.style.width = width + 'px';
        star.style.height = height + 'px';
        star.style.animationDuration = duration + 's';

        parent.appendChild(star);
    }
})();

// __PAGE_TRANSITION_START__

// runs when the page is unloaded
const titan_outro = (href) => {
    const tl = titanGsap.timeline({
        onComplete: fire_outro_complete,
        onCompleteParams: [href],
    });

    tl.set('.gfx_preloader--rocket', {
        yPercent: 250,
    });

    tl.titanOutro('.gfx_preloader');

    tl.to('.gfx_preloader--rocket', {
        yPercent: 0,
    });

    tl.to(
        '.gfx_preloader--star',
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
        defaults: { duration: 1 },
        onComplete: () => {
            titanGsap.set('.gfx_preloader--star', {
                autoAlpha: 0,
            });
        },
    });

    tl.to('.gfx_preloader--rocket', {
        yPercent: -200,
    });

    tl.titanIntro('.gfx_preloader', null, '0');
};

(() => {
    const tl = titanGsap.timeline({
        repeat: -1,
        yoyo: true,
        defaults: {
            duration: 1,
        },
    });

    tl.to('.gfx_preloader--rocket', {
        y: 10,
        ease: 'power1.inOut',
    });

    titanGsap.to('.gfx_preloader--rocket .fire', {
        scaleY: 0.8,
        ease: 'power1.inOut',
        repeat: -1,
        yoyo: true,
        duration: 0.5,
    });
})();

window.addEventListener('load', () => {
    const event = new CustomEvent('titan-intro-complete');
    window.dispatchEvent(event);
});
