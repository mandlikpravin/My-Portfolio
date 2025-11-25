'use strict';

(() => {
    let gfx_session_key = sessionStorage.getItem('gfxpartner_titan_preloader');

    if (gfx_session_key != null && gfx_session_key == 'done') {
        let bg_intro = document.querySelector('.gfx_preloader--bg-intro');
        let progress_bar = document.querySelector(
            '.gfx_preloader--progress-bar'
        );
        let el = document.querySelector('.gfx_preloader');
        if (bg_intro != null) bg_intro.remove();
        if (progress_bar != null) progress_bar.remove();
        if (el != null) el.remove();
    } else {
        sessionStorage.setItem('gfxpartner_titan_preloader', 'done');
    }

    // remove the outro if once per tab is active
    let bg_outro = document.querySelector('.gfx_preloader--bg-outro');
    if (bg_outro != null) bg_outro.remove();
})();
