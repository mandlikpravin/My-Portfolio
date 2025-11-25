'use strict';

titanGsap.registerEffect({
    name: 'titanOutro',
    effect: (targets) => {
        const tl = titanGsap.timeline();

        tl.set(targets, {
            autoAlpha: 0,
            xPercent: 0,
            yPercent: -50,
        });

        tl.to(targets, {
            autoAlpha: 1,
            yPercent: 0,
            duration: 1,
            ease: Power4.easeInOut,
        });

        return tl;
    },
    extendTimeline: true,
});
