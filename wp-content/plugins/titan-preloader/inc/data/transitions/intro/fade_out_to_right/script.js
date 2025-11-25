'use strict';

titanGsap.registerEffect({
    name: 'titanIntro',
    effect: (targets) => {
        const tl = titanGsap.timeline();

        tl.to(targets, {
            autoAlpha: 0,
            yPercent: 50,
            duration: 1,
            ease: 'power4.in',
        });

        return tl;
    },
    extendTimeline: true,
});
