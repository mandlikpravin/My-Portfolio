'use strict';

const titan_progress_start_anim = () => {
    const tl = titanGsap.timeline();

    tl.to('.gfx_preloader--progress-bar', {
        autoAlpha: 1,
    });

    tl.to('.gfx_preloader--progress-actual', {
        x: '-60%',
    });
};

const titan_progress_complete_anim = () => {
    const tl = titanGsap.timeline();

    tl.to('.gfx_preloader--progress-actual', {
        x: 0,
    });

    tl.to('.gfx_preloader--progress-bar', {
        autoAlpha: 0,
    });
};
