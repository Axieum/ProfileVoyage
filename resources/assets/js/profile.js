window.ScrollReveal = require('scrollreveal');

window.onload = function() {
    let cards = document.getElementsByClassName('card');
    for(let i = 0; i < cards.length; i++) {
        cards[i].style.display = 'flex!important';
    }
    setTimeout(function() {
        let ele = document.getElementsByTagName('img');
        ele[1].style.opacity = 1;
    }, 0);
    setTimeout(function() {
        let ele = document.getElementsByClassName('profile-info');
        ele[0].style.opacity = 1;
    }, 250);
    setTimeout(function() {
        let ele = document.getElementsByClassName('profile-divider');
        ele[0].style.width = '60%';
    }, 500);
    setTimeout(function() {
        let ele = document.getElementsByClassName('navbar');
        ele[0].style.top = 0;
        ele[0].style.opacity = 1;
    }, 750);
    setTimeout(function() {
        document.getElementById('profile-links').style.opacity = 1;

        // Scroll Reveal
        window.sr = ScrollReveal({reset: true});
        // Custom reveal sequencing by container
        let wrappers = document.getElementsByClassName('social-wrapper');
        for (let i = 0; i < wrappers.length; i++) {
            let cards = wrappers[i].getElementsByClassName('card');
            for (let z = 0; z < cards.length; z++) {
                sr.reveal(cards[z], {reset: true, viewFactor: 0.2}, 50);
            }
        }
    }, 1100);
    var getElementsInArea = (function(docElm){
        var viewportHeight = docElm.clientHeight;

        return function(e, opts){
            var found = [], i;

            if( e && e.type == 'resize' )
                viewportHeight = docElm.clientHeight;

            for( i = opts.elements.length; i--; ){
                var elm        = opts.elements[i],
                    pos        = elm.getBoundingClientRect(),
                    topPerc    = pos.top    / viewportHeight * 100,
                    bottomPerc = pos.bottom / viewportHeight * 100,
                    middle     = (topPerc + bottomPerc)/2,
                    inViewport = middle > opts.zone[1] &&
                                 middle < (100-opts.zone[1]);

                elm.classList.toggle(opts.markedClass, inViewport);

                if( inViewport )
                    found.push(elm);
            }
        };
    })(document.documentElement);

    window.addEventListener('scroll', f)
    window.addEventListener('resize', f)

    function f(e){
        getElementsInArea(e, {
            elements    : document.querySelectorAll('#profile-links .column'),
            markedClass : 'is--active',
            zone        : [40, 40]
        });
    }
};
