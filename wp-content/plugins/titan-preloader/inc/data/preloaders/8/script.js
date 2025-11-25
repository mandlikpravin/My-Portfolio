'use strict';

(() => {
    let parent = document.querySelector('.gfx_preloader--text-inner');
    if (parent == null) return;
    parent.style.height = parent.firstElementChild.offsetHeight + 'px';
})();

// __PAGE_TRANSITION_START__

// runs when the page is unloaded
const titan_outro = (href) => {
    const tl = titanGsap.timeline({
        onComplete: fire_outro_complete,
        onCompleteParams: [href],
    });

    tl.set('.gfx_preloader--text-inner', {
        y: 0,
    });

    const progressBar = document.querySelector('.gfx_preloader--progress:not(.gfx-progress-bar-disabled) .gfx_preloader--progress-actual');
    if (progressBar != null) {
        tl.set(progressBar, {
            x: 0,
        });
    }

    const percentText = document.querySelector('.gfx_preloader--percent:not(.gfx-progress-bar-disabled)');
    if (percentText != null) {
        tl.set(percentText, {
            innerText: '0%',
        });
    }

    tl.titanOutro('.gfx_preloader');
};

// __PAGE_TRANSITION_END__

// runs when the page is loaded
const titan_intro = () => {
    const tl = titanGsap.timeline({
        defaults: {
            duration: 0.75,
        },
    });

    let parent = document.querySelector('.gfx_preloader--text-inner');
    if (parent == null) return;
    let percent = 100 / parent.children.length;
    let percent_value = percent;

    Array.from(parent.children).forEach((child, index) => {

        const progressBar = document.querySelector('.gfx_preloader--progress:not(.gfx-progress-bar-disabled) .gfx_preloader--progress-actual');
        if (progressBar != null) {
            tl.to(progressBar, {
                x: percent_value + '%',
            });
        }

        const percentText = document.querySelector('.gfx_preloader--percent:not(.gfx-progress-bar-disabled)');
        if (percentText != null) {
            tl.to(
                percentText,
                {
                    innerText: percent_value + '%',
                    snap: 'innerText',
                },
                '<'
            );
        }

        tl.to(
            '.gfx_preloader--text-inner',
            {
                y: -1 * parent.offsetHeight * index,
                ease: 'back.out(1.7)',
            },
            progressBar != null ? '<' : '<+=.75' 
        );

        percent_value += percent;
    });

    tl.titanIntro('.gfx_preloader');
};

window.addEventListener('load', () => {
    const event = new CustomEvent('titan-intro-complete');
    window.dispatchEvent(event);
});
