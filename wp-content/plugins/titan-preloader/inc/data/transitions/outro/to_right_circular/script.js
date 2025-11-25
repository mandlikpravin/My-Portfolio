'use strict';

titanGsap.registerEffect({
    name: 'titanOutro',
    effect: (targets) => {
        const tl = titanGsap.timeline();

        tl.set(targets, {
            xPercent: -100,
            yPercent: 0,
            autoAlpha: 1,
            overwrite: true,
        });

        tl.to(
            '.gfx_preloader--circular-outro',
            {
                x: '0%',
                ease: Power4.easeInOut,
                duration: 2,
            },
            '<'
        );

        tl.to(
            '.gfx_preloader--circular-outro',
            {
                'border-radius': '0%',
                ease: Power4.easeOut,
                duration: 1,
            },
            '<+=1'
        );

        tl.to(
            targets,
            {
                xPercent: 0,
                ease: Power3.easeInOut,
                duration: 1,
            },
            '.5'
        );

        return tl;
    },
    extendTimeline: true,
});
