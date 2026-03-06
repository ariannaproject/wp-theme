// gestione del menu (migliorata)
const menuIcon = document.getElementById('menu-mobile-icon');
const menuMobile = document.getElementById('menu-mobile-dropdown');
const menuTop = document.getElementById('menu-mobile');

if (menuTop && menuIcon && menuMobile) {
    const closeMenu = () => {
        menuTop.classList.remove('open');
    };

    const openMenu = () => {
        menuTop.classList.add('open');
    };

    menuIcon.addEventListener('click', () => {
        if (menuTop.classList.contains('open')) closeMenu();
        else openMenu();
    });

    // close when clicking any link inside the mobile menu
    menuMobile.querySelectorAll('a').forEach(a => {
        a.addEventListener('click', () => {
            closeMenu();
        });
    });

    // close on ESC
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && menuTop.classList.contains('open')) {
            closeMenu();
        }
    });
}

// Filters
var text = null;
var category = 'all';

function initFilters(parentDivId, filterTextId = null, filterButtonsId = null) {
    const filterTextInput = filterTextId ? document.getElementById(filterTextId) : null;
    const buttons = document.querySelectorAll(`#${filterButtonsId} .btn-select`) || [];

    buttons.forEach(button => {
        button.addEventListener('click', () => {
            const cat = button.getAttribute('data-category');
            
            buttons.forEach(btn => btn.classList.remove('active'));
            button.classList.add('active');

            category = cat;
            filterCards(parentDivId);
        });
    });

    if (filterTextInput) {
        filterTextInput.addEventListener('input', () => {
            text = filterTextInput.value.trim();
            filterCards(parentDivId);
        });
    }
}

function filterCards(parentDivId) {
    const parentDiv = document.getElementById(parentDivId);

    let count = 0;
    const cards = parentDiv.querySelectorAll('.card');
    cards.forEach(card => {
        if ((text === null || card.textContent.includes(text)) && (category === null || category === 'all' || card.getAttribute('data-category') === category)) {
            card.style.display = '';
            count++;
        } else {
            card.style.display = 'none';
        }
    });
    const countSpan = document.getElementById('filter-count');
    if (countSpan) {
        countSpan.textContent = count;
    }
}

/* Continuous features carousel: wraps cards into a track, clones content and animates it */
(function initContinuousCarousel() {
    const containers = document.querySelectorAll('.features-carousel');
    containers.forEach(container => {
        // move direct .card children into a track
        const cards = Array.from(container.querySelectorAll(':scope > .card'));
        if (!cards.length) return;

        const track = document.createElement('div');
        track.className = 'features-carousel-track';
        cards.forEach(c => track.appendChild(c));
        // clear container and append track (preserve container classes)
        container.appendChild(track);

        // duplicate the track content once for a seamless loop
        track.innerHTML = track.innerHTML + track.innerHTML;

        // measure half width (one full set)
        const halfWidth = track.scrollWidth / 2;

        let pos = 0;
        const speed = 0.03; // pixels per millisecond, lower = slower
        let last = performance.now();
        let paused = false;

        container.addEventListener('mouseenter', () => { paused = true; });
        container.addEventListener('mouseleave', () => { paused = false; last = performance.now(); });

        function step(now) {
            const dt = now - last;
            last = now;
            if (!paused) {
                pos -= speed * dt;
                if (Math.abs(pos) >= halfWidth) {
                    // reset position to create seamless loop
                    pos += halfWidth;
                }
                track.style.transform = `translateX(${pos}px)`;
            }
            requestAnimationFrame(step);
        }

        track.style.transform = 'translateX(0px)';
        requestAnimationFrame(step);
    });
})();