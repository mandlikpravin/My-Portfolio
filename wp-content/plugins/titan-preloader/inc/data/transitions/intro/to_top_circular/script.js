'use strict';

titanGsap.registerEffect({
    name: 'titanIntro',
    effect: (targets) => {
        const bg = document.querySelector('.gfx_preloader--circular-intro');

        const tl = titanGsap.timeline({
            onComplete: () => bg.remove(),
        });

        tl.to(targets, {
            yPercent: -100,
            ease: Power3.easeInOut,
            duration: 1,
        });

        tl.to(
            bg,
            {
                y: '-100%',
                'border-bottom-left-radius': '50%',
                'border-bottom-right-radius': '50%',
                ease: Power4.easeOut,
                duration: 2,
            },
            '<'
        );

        return tl;
    },
    extendTimeline: true,
});
