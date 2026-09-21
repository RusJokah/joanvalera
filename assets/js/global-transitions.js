/*
==================================================
JOAN VALERA
GLOBAL PAGE TRANSITIONS
VERSION 3.0
==================================================
*/

(function () {

    'use strict';


    /*
    ==================================================
    01. BROWSER SCROLL RESTORATION
    ==================================================
    */

    if (
        'scrollRestoration' in history
    ) {

        history.scrollRestoration = 'auto';

    }


    /*
    ==================================================
    02. INTERNAL LINK HANDLER
    ==================================================
    */

    document.addEventListener(
        'click',
        function (event) {

            /*
            ------------------------------------------
            Find clicked link.
            ------------------------------------------
            */

            const link =
                event.target.closest('a');


            if (!link) {
                return;
            }


            /*
            ------------------------------------------
            Only normal left clicks.
            ------------------------------------------
            */

            if (
                event.button !== 0 ||
                event.metaKey ||
                event.ctrlKey ||
                event.shiftKey ||
                event.altKey
            ) {

                return;

            }


            /*
            ==================================================
            IMPORTANT:
            IGNORE ELEMENTOR LIGHTBOX LINKS
            ==================================================
            */

            if (
                link.hasAttribute(
                    'data-elementor-open-lightbox'
                )
            ) {

                return;

            }


            /*
            ------------------------------------------
            Ignore Elementor lightbox elements.
            ------------------------------------------
            */

            if (
                link.closest(
                    '[data-elementor-open-lightbox="yes"]'
                )
            ) {

                return;

            }


            /*
            ------------------------------------------
            Ignore common lightbox elements.
            ------------------------------------------
            */

            if (
                link.classList.contains(
                    'elementor-clickable'
                ) &&
                link.hasAttribute('data-elementor-open-lightbox')
            ) {

                return;

            }


            /*
            ------------------------------------------
            Ignore downloads.
            ------------------------------------------
            */

            if (
                link.hasAttribute(
                    'download'
                )
            ) {

                return;

            }


            /*
            ------------------------------------------
            Ignore links with a target.
            ------------------------------------------
            */

            if (
                link.target &&
                link.target !== '_self'
            ) {

                return;

            }


            /*
            ------------------------------------------
            Get URL.
            ------------------------------------------
            */

            const href =
                link.getAttribute('href');


            if (!href) {
                return;
            }


            /*
            ------------------------------------------
            Ignore anchors.
            ------------------------------------------
            */

            if (
                href.charAt(0) === '#'
            ) {

                return;

            }


            /*
            ------------------------------------------
            Ignore javascript links.
            ------------------------------------------
            */

            if (
                href.indexOf(
                    'javascript:'
                ) === 0
            ) {

                return;

            }


            /*
            ------------------------------------------
            Destination URL.
            ------------------------------------------
            */

            let destination;

            try {

                destination =
                    new URL(
                        href,
                        window.location.href
                    );

            } catch (error) {

                return;

            }


            /*
            ------------------------------------------
            Only internal links.
            ------------------------------------------
            */

            if (
                destination.origin !==
                window.location.origin
            ) {

                return;

            }


            /*
            ------------------------------------------
            Ignore same-page URL.
            ------------------------------------------
            */

            if (
                destination.href ===
                window.location.href
            ) {

                return;

            }


            /*
            ==================================================
            IMAGE FILES
            ==================================================
            */

            const pathname =
                destination.pathname.toLowerCase();


            if (
                pathname.endsWith('.jpg') ||
                pathname.endsWith('.jpeg') ||
                pathname.endsWith('.png') ||
                pathname.endsWith('.webp') ||
                pathname.endsWith('.gif') ||
                pathname.endsWith('.avif')
            ) {

                return;

            }


            /*
            ==================================================
            START GLOBAL PAGE TRANSITION
            ==================================================
            */

            event.preventDefault();


            /*
            ------------------------------------------
            Reduced motion.

            CORRECCION: antes se anadia siempre la clase
            'jv-page-leaving' y se esperaban 420ms antes de
            navegar, incluso con "reducir movimiento"
            activado en el sistema. El CSS (global-transitions.css)
            ya respeta prefers-reduced-motion y no anima nada
            en ese caso, pero el JS seguia retrasando la
            navegacion 420ms sin ningun motivo visual. Ahora,
            si el usuario tiene activado reducir movimiento,
            se navega al instante, sin retraso artificial.
            ------------------------------------------
            */

            const reducedMotion =
                window.matchMedia(
                    '(prefers-reduced-motion: reduce)'
                ).matches;


            if (reducedMotion) {

                window.location.href =
                    destination.href;

                return;

            }


            document.documentElement.classList.add(
                'jv-page-leaving'
            );


            /*
            ------------------------------------------
            Navigate after transition.

            NOTA: estos 420ms deben coincidir con la
            duracion de "transition: opacity 420ms ..."
            de html.jv-page-leaving en global-transitions.css.
            Si se cambia uno, hay que cambiar el otro.
            ------------------------------------------
            */

            window.setTimeout(
                function () {

                    window.location.href =
                        destination.href;

                },
                420
            );

        }
    );


})();