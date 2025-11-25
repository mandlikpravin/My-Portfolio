'use strict';

titanGsap.registerEffect({
    name: 'titanOutro',
    effect: (targets) => {
        const tl = titanGsap.timeline();

        tl.set(targets, {
            xPercent: 100,
            yPercent: 0,
            autoAlpha: 1,
            overwrite: true,
        });

        tl.to(targets, {
            xPercent: 0,
            duration: 1,
            ease: Power4.easeInOut,
        });

        return tl;
    },
    extendTimeline: true,
});
