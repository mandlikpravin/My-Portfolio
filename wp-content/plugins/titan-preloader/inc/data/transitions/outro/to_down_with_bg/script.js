'use strict';

titanGsap.registerEffect({
    name: 'titanOutro',
    effect: (targets, config) => {
        let bg = document.querySelector('.gfx_preloader--bg-outro');

        const tl = titanGsap.timeline();

        tl.set(targets, {
            xPercent: 0,
            yPercent: -100,
            autoAlpha: 1,
            overwrite: true,
        });

        tl.to(bg, {
            y: 0,
            duration: 1,
            ease: Power4.easeInOut,
        });

        tl.to(targets, {
            yPercent: 0,
            duration: 1,
            ease: Power4.easeInOut,
        });

        return tl;
    },
    extendTimeline: true,
});
