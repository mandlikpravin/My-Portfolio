'use strict';

titanGsap.registerEffect({
    name: 'titanIntro',
    effect: (targets, config) => {
        let bg = document.querySelector('.gfx_preloader--bg-intro');

        const tl = titanGsap.timeline({
            onComplete: () => {
                if (bg == null) return;
                bg.remove();
            },
        });

        tl.to(targets, {
            yPercent: 100,
            duration: 0.75,
            ease: 'power4.in',
        });

        tl.to(
            bg,
            {
                yPercent: 100,
                duration: 0.75,
                delay: 0.25,
                ease: 'power4.inOut',
            },
            '<+=.3'
        );

        return tl;

        // return titanGsap.to(targets, {duration: config.duration, opacity: 0});
    },
    // defaults: { duration: 2 },
    extendTimeline: true,
});
