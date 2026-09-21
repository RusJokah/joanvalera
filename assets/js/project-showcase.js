/*
==================================================
JOAN VALERA — CINEMATIC PROJECT SHOWCASE
Version: 4.0.0
==================================================
*/

(function () {

    'use strict';


    /*
    ==================================================
    01. PROJECTS
    ==================================================
    */

    const projects =
        document.querySelectorAll('.jv-project');


    if (!projects.length) {
        return;
    }


    /*
    ==================================================
    02. REVEAL ON SCROLL
    ==================================================
    */

    const observer =
        new IntersectionObserver(

            function (entries) {

                entries.forEach(
                    function (entry) {

                        if (entry.isIntersecting) {

                            entry.target.classList.add(
                                'is-visible'
                            );

                            observer.unobserve(
                                entry.target
                            );

                        }

                    }
                );

            },

            {
                threshold: 0.18
            }

        );


    projects.forEach(
        function (project) {

            observer.observe(project);

        }
    );


    /*
    ==================================================
    03. DEVICE CHECK
    ==================================================
    */

    const supportsHover =
        window.matchMedia(
            '(hover: hover) and (pointer: fine)'
        ).matches;


    /*
    ==================================================
    04. 3D TILT
    ==================================================
    */

    if (supportsHover) {

        projects.forEach(
            function (project) {

                const image =
                    project.querySelector(
                        '.jv-project__image'
                    );


                const content =
                    project.querySelector(
                        '.jv-project__content'
                    );


                if (!image || !content) {
                    return;
                }


                let animationFrame = null;


                project.addEventListener(
                    'mousemove',
                    function (event) {

                        if (
                            project.classList.contains(
                                'is-exiting'
                            )
                        ) {
                            return;
                        }


                        if (animationFrame) {

                            cancelAnimationFrame(
                                animationFrame
                            );

                        }


                        animationFrame =
                            requestAnimationFrame(
                                function () {

                                    const rect =
                                        project.getBoundingClientRect();


                                    const x =
                                        event.clientX -
                                        rect.left;


                                    const y =
                                        event.clientY -
                                        rect.top;


                                    const centerX =
                                        rect.width / 2;


                                    const centerY =
                                        rect.height / 2;


                                    const normalizedX =
                                        (x - centerX) /
                                        centerX;


                                    const normalizedY =
                                        (y - centerY) /
                                        centerY;


                                    const rotateY =
                                        normalizedX * 4;


                                    const rotateX =
                                        normalizedY * -4;


                                    const imageX =
                                        normalizedX * -10;


                                    const imageY =
                                        normalizedY * -10;


                                    const contentX =
                                        normalizedX * 5;


                                    const contentY =
                                        normalizedY * 5;


                                    project.style.transform =
                                        `
                                        rotateX(${rotateX}deg)
                                        rotateY(${rotateY}deg)
                                        scale3d(1.008, 1.008, 1)
                                        `;


                                    image.style.setProperty(
                                        '--jv-image-x',
                                        imageX + 'px'
                                    );


                                    image.style.setProperty(
                                        '--jv-image-y',
                                        imageY + 'px'
                                    );


                                    content.style.setProperty(
                                        '--jv-content-x',
                                        contentX + 'px'
                                    );


                                    content.style.setProperty(
                                        '--jv-content-y',
                                        contentY + 'px'
                                    );

                                }
                            );

                    }
                );


                /*
                ==============================================
                MOUSE LEAVE
                ==============================================
                */

                project.addEventListener(
                    'mouseleave',
                    function () {

                        if (
                            project.classList.contains(
                                'is-exiting'
                            )
                        ) {
                            return;
                        }


                        if (animationFrame) {

                            cancelAnimationFrame(
                                animationFrame
                            );

                        }


                        project.style.transform =
                            'rotateX(0deg) rotateY(0deg) scale3d(1, 1, 1)';


                        image.style.setProperty(
                            '--jv-image-x',
                            '0px'
                        );


                        image.style.setProperty(
                            '--jv-image-y',
                            '0px'
                        );


                        content.style.setProperty(
                            '--jv-content-x',
                            '0px'
                        );


                        content.style.setProperty(
                            '--jv-content-y',
                            '0px'
                        );

                    }
                );

            }
        );

    }


    /*
    ==================================================
    05. CINEMATIC IMAGE TRANSITION
    ==================================================
    */

    projects.forEach(
        function (project) {

            project.addEventListener(
                'click',
                function (event) {

                    /*
                    ------------------------------------------
                    Only intercept normal left clicks.
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
                    ------------------------------------------
                    Reduced motion
                    ------------------------------------------
                    */

                    const reducedMotion =
                        window.matchMedia(
                            '(prefers-reduced-motion: reduce)'
                        ).matches;


                    if (reducedMotion) {
                        return;
                    }


                    /*
                    ------------------------------------------
                    Destination
                    ------------------------------------------
                    */

                    const destination =
                        project.getAttribute(
                            'data-project-url'
                        );


                    if (!destination) {
                        return;
                    }


                    /*
                    ------------------------------------------
                    Prevent normal navigation.
                    ------------------------------------------
                    */

                    event.preventDefault();


                    /*
                    ------------------------------------------
                    Prevent double click.
                    ------------------------------------------
                    */

                    if (
                        project.classList.contains(
                            'is-exiting'
                        )
                    ) {

                        return;

                    }


                    /*
                    ------------------------------------------
                    Start cinematic exit.
                    ------------------------------------------
                    */

                    project.classList.add(
                        'is-exiting'
                    );


                    /*
                    ------------------------------------------
                    Navigate.
                    ------------------------------------------
                    */

                    window.setTimeout(
                        function () {

                            window.location.href =
                                destination;

                        },
                        850
                    );

                }
            );

        }
    );


    /*
    ==================================================
    06. PAGE RESTORATION
    ==================================================
    */

    window.addEventListener(
        'pageshow',
        function () {

            projects.forEach(
                function (project) {

                    project.classList.remove(
                        'is-exiting'
                    );

                }
            );

        }
    );


})();