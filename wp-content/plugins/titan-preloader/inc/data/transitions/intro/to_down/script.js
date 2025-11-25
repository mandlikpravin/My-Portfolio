'use strict';

titanGsap.registerEffect({
    name: 'titanIntro',
    effect: (targets, config) => {
        const tl = titanGsap.timeline();

        tl.to(targets, {
            yPercent: 100,
            duration: 1,
            ease: 'power4.in',
        });

        return tl;
    },
    extendTimeline: true,
});
