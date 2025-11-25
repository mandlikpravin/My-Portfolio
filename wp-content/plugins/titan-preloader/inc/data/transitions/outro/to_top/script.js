'use strict';

titanGsap.registerEffect({
    name: 'titanOutro',
    effect: (targets, config) => {
        const tl = titanGsap.timeline();

        tl.set(targets, {
            xPercent: 0,
            yPercent: 100,
            autoAlpha: 1,
            overwrite: true,
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
