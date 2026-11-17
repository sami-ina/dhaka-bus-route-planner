/**
 * Dhaka Bus Route Planner & Transit Information System
 * Client-side Interactivity (Vanilla JavaScript)
 */

document.addEventListener('DOMContentLoaded', () => {
    // 1. Mobile Menu Toggle
    const menuToggle = document.getElementById('menuToggle');
    const mobileNav = document.getElementById('mobileNav');

    if (menuToggle && mobileNav) {
        menuToggle.addEventListener('click', () => {
            const isExpanded = menuToggle.getAttribute('aria-expanded') === 'true';
            menuToggle.setAttribute('aria-expanded', !isExpanded);
            mobileNav.classList.toggle('open');
        });
    }

    // 2. Origin & Destination Swap Button
    const swapBtn = document.getElementById('swapPlacesBtn');
    const fromInput = document.getElementById('fromInput');
    const toInput = document.getElementById('toInput');

    if (swapBtn && fromInput && toInput) {
        swapBtn.addEventListener('click', () => {
            const temp = fromInput.value;
            fromInput.value = toInput.value;
            toInput.value = temp;

            // Optional visual rotation feedback
            swapBtn.style.transition = 'transform 250ms ease';
            swapBtn.style.transform = 'rotate(180deg)';
            setTimeout(() => {
                swapBtn.style.transform = '';
            }, 250);
        });
    }

    // 3. Geolocation: "Use my current location"
    const geoBtn = document.getElementById('geoBtn');
    const locationStatus = document.getElementById('locationStatus');

    if (geoBtn && fromInput && locationStatus) {
        geoBtn.addEventListener('click', () => {
            if (!navigator.geolocation) {
                locationStatus.textContent = locationStatus.getAttribute('data-unsupported') || 'Location is not supported by this browser.';
                return;
            }

            locationStatus.textContent = locationStatus.getAttribute('data-finding') || 'Finding your location…';

            navigator.geolocation.getCurrentPosition(
                (position) => {
                    fromInput.value = locationStatus.getAttribute('data-current') || 'Current location, Dhaka';
                    locationStatus.textContent = locationStatus.getAttribute('data-selected') || 'Current location selected.';
                },
                (error) => {
                    locationStatus.textContent = locationStatus.getAttribute('data-unavailable') || 'Location access unavailable. Type your starting place.';
                },
                { timeout: 10000 }
            );
        });
    }

    // 4. Quick Access Destination Buttons
    const quickButtons = document.querySelectorAll('.quick-dest-btn');
    if (quickButtons.length > 0 && toInput) {
        quickButtons.forEach(btn => {
            btn.addEventListener('click', () => {
                const destination = btn.getAttribute('data-place');
                if (destination) {
                    toInput.value = destination;
                    const searchForm = document.getElementById('journeySearchForm');
                    if (searchForm) {
                        searchForm.submit();
                    }
                }
            });
        });
    }

    // 5. Client-Side Sorting on Routes Page (Fastest vs Lowest Fare)
    const sortBtn = document.getElementById('sortToggleBtn');
    const routesContainer = document.getElementById('routesListContainer');

    if (sortBtn && routesContainer) {
        let currentSort = 'fastest'; // 'fastest' | 'fare'

        sortBtn.addEventListener('click', () => {
            const cards = Array.from(routesContainer.querySelectorAll('.route-result'));
            if (cards.length <= 1) return;

            if (currentSort === 'fastest') {
                currentSort = 'fare';
                cards.sort((a, b) => {
                    const fareA = parseInt(a.getAttribute('data-fare') || '0', 10);
                    const fareB = parseInt(b.getAttribute('data-fare') || '0', 10);
                    return fareA - fareB;
                });
                sortBtn.innerHTML = `Sort: Lowest Fare &uarr;&darr;`;
            } else {
                currentSort = 'fastest';
                cards.sort((a, b) => {
                    const timeA = parseInt(a.getAttribute('data-duration') || '0', 10);
                    const timeB = parseInt(b.getAttribute('data-duration') || '0', 10);
                    return timeA - timeB;
                });
                sortBtn.innerHTML = `Sort: Fastest &uarr;&darr;`;
            }

            cards.forEach(card => routesContainer.appendChild(card));
        });
    }
});

