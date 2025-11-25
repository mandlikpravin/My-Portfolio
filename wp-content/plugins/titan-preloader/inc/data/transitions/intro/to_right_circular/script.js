'use strict';

titanGsap.registerEffect({
    name: 'titanIntro',
    effect: (targets) => {
        const bg = document.querySelector('.gfx_preloader--circular-intro');

        const tl = titanGsap.timeline({
            onComplete: () => bg.remove(),
        });

        tl.to(targets, {
            xPercent: 100,
            ease: Power3.easeInOut,
            duration: 2,
        });

        tl.to(
            bg,
            {
                x: '100%',
                'border-radius': '50%',
                ease: Power4.easeInOut,
                duration: 2.5,
            },
            '<'
        );

        return tl;
    },
    extendTimeline: true,
});
