'use strict';

titanGsap.registerEffect({
    name: 'titanOutro',
    effect: (targets) => {
        const tl = titanGsap.timeline();

        tl.set(targets, {
            autoAlpha: 0,
            xPercent: -50,
            yPercent: 0,
        });

        tl.to(targets, {
            autoAlpha: 1,
            xPercent: 0,
            duration: 1,
            ease: Power4.easeInOut,
        });

        return tl;
    },
    extendTimeline: true,
});
