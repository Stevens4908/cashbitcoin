/**
 * Selection Lite
 * Carefully selected Elementor addons bundle, for building the most awesome websites
 *
 * @encoding        UTF-8
 * @version         1.7
 * @copyright       (C) 2018 - 2021 Merkulove ( https://merkulov.design/ ). All rights reserved.
 * @license         GPLv3
 * @contributors    merkulove, vladcherviakov, phoenixmkua, podolianochka, viktorialev01
 * @support         help@merkulov.design
 **/

"use strict";

/**
 * Mdp uper main object
 * @type {{ addUper: mdpUper.addUper, scrollTopButton: mdpUper.scrollTopButton }}
 */
const mdpUper = {
    scrollTopButton: function ( wrapperName ) {
        const $button = document.querySelector( `.${wrapperName} .mdp-uper-elementor-button` );
        const offset = +document.querySelector( `.${wrapperName}` ).dataset.offset;
        const offsetType = document.querySelector( `.${wrapperName}` ).dataset.offsetType;
        const getTopOffset = () => window.pageYOffset || document.documentElement.scrollTop;
        const customElementId = document.querySelector( `.${wrapperName}` ).dataset.customElementId;
        const autoHideSeconds = document.querySelector( `.${wrapperName}` ).dataset.autohideSeconds;
        const buttonAppearanceAnimation = document.querySelector( `.${wrapperName}` ).dataset.buttonAppearanceAnimation;
        const buttonHoverAnimation = document.querySelector( `.${wrapperName}` ).dataset.buttonHoverAnimation;
        const scrollTo = document.querySelector( `.${wrapperName}` ).dataset.scrollTo;
        const anchorId = document.querySelector( `.${wrapperName}` ).dataset.anchorId;
        const scrollSpeed = document.querySelector( `.${wrapperName}` ).dataset.scrollSpeed;
        const scrollEasing = document.querySelector( `.${wrapperName}` ).dataset.scrollEasing;
        const isFixed = document.querySelector( `.${wrapperName}` ).dataset.isFixed;
        const isScrollIndicator = document.querySelector( `.${wrapperName} ` ).dataset.scrollIndicator;
        let circleIndicator;
        let circleLength;
        let circleRadius;
        let timeout;

        // scroll indicator
        if ( isScrollIndicator === 'yes' && isFixed === 'yes' ) {
            const $svg = document.querySelector( `.${wrapperName} .mdp-uper-elementor-scroll-indicator-svg` );
            const $circle = document.querySelector( `.${wrapperName} .mdp-uper-elementor-scroll-indicator-circle` );
            const widescreenRadius = document.querySelector( `.${wrapperName} ` ).dataset.radiusWidescreen;
            const desktopRadius = document.querySelector( `.${wrapperName}` ).dataset.radius;
            const laptopRadius = document.querySelector( `.${wrapperName} ` ).dataset.radiusLaptop;
            const tabletExtraRadius = document.querySelector( `.${wrapperName} ` ).dataset.radiusTabletExtra;
            const tabletRadius = document.querySelector( `.${wrapperName}` ).dataset.radiusTablet;
            const mobileExtraRadius = document.querySelector( `.${wrapperName}` ).dataset.radiusMobileExtra;
            const mobileRadius = document.querySelector( `.${wrapperName}` ).dataset.radiusMobile;
            circleIndicator = document.querySelector( `.${wrapperName} .mdp-uper-elementor-scroll-indicator-circle` );

            function setCircleIndicatorSizes() {

                // set responsive radius radius
                if ( elementorFrontend.config.responsive.activeBreakpoints.hasOwnProperty( 'widescreen' )
                    && window.matchMedia( `(min-width: ${elementorFrontend.config.responsive.activeBreakpoints.widescreen.value}px)` ).matches
                    && widescreenRadius ) {
                    $circle.setAttribute( 'r', widescreenRadius );
                    $circle.setAttribute( 'cx', widescreenRadius );
                    $circle.setAttribute( 'cy', widescreenRadius );
                }

                if ( widescreenRadius && elementorFrontend.config.responsive.activeBreakpoints.hasOwnProperty( 'widescreen' ) ) {
                    if ( window.matchMedia( `(min-width: ${elementorFrontend.config.responsive.activeBreakpoints.tablet.value + 1}px)` ).matches
                        && window.matchMedia( `(max-width: ${elementorFrontend.config.responsive.activeBreakpoints.widescreen.value - 1}px)` ).matches ) {
                        $circle.setAttribute( 'r', desktopRadius );
                        $circle.setAttribute( 'cx', desktopRadius );
                        $circle.setAttribute( 'cy', desktopRadius );
                    }
                } else {
                    if ( window.matchMedia( `(min-width: ${elementorFrontend.config.responsive.activeBreakpoints.tablet.value + 1}px)` ).matches ) {
                        $circle.setAttribute( 'r', desktopRadius );
                        $circle.setAttribute( 'cx', desktopRadius );
                        $circle.setAttribute( 'cy', desktopRadius );
                    }
                }

                if ( elementorFrontend.config.responsive.activeBreakpoints.hasOwnProperty( 'laptop' )
                    && window.matchMedia( `(max-width: ${elementorFrontend.config.responsive.activeBreakpoints.laptop.value}px)` ).matches
                    && laptopRadius ) {
                    $circle.setAttribute( 'r', laptopRadius );
                    $circle.setAttribute( 'cx', laptopRadius );
                    $circle.setAttribute( 'cy', laptopRadius );
                }

                if ( elementorFrontend.config.responsive.activeBreakpoints.hasOwnProperty( 'tablet_extra' )
                    && window.matchMedia( `(max-width: ${elementorFrontend.config.responsive.activeBreakpoints.tablet_extra.value}px) ` ).matches
                    && tabletExtraRadius ) {
                    $circle.setAttribute( 'r', tabletExtraRadius );
                    $circle.setAttribute( 'cx', tabletExtraRadius );
                    $circle.setAttribute( 'cy', tabletExtraRadius );
                }

                if ( window.matchMedia( `(max-width: ${elementorFrontend.config.responsive.activeBreakpoints.tablet.value}px)` ).matches && tabletRadius ) {
                    $circle.setAttribute( 'r', tabletRadius );
                    $circle.setAttribute( 'cx', tabletRadius );
                    $circle.setAttribute( 'cy', tabletRadius );
                }

                if ( elementorFrontend.config.responsive.activeBreakpoints.hasOwnProperty( 'mobile_extra' )
                    && window.matchMedia( ` (max-width: ${elementorFrontend.config.responsive.activeBreakpoints.mobile_extra.value}px) ` ).matches
                    && mobileExtraRadius ) {
                    $circle.setAttribute( 'r', mobileExtraRadius );
                    $circle.setAttribute( 'cx', mobileExtraRadius );
                    $circle.setAttribute( 'cy', mobileExtraRadius );
                }

                if ( window.matchMedia( `(max-width: ${elementorFrontend.config.responsive.activeBreakpoints.mobile.value}px)` ).matches && mobileRadius ) {
                    $circle.setAttribute( 'r', mobileRadius );
                    $circle.setAttribute( 'cx', mobileRadius );
                    $circle.setAttribute( 'cy', mobileRadius );
                }

                circleRadius = $circle.r.baseVal.value;

                circleLength = 2 * Math.PI * circleRadius;

                circleIndicator.style.strokeDasharray = `${circleLength} ${circleLength}`;
                circleIndicator.style.transition = 'stroke-dashoffset 20ms';

                // svg height and width
                $svg.style.height = 2 * circleRadius + 'px';
                $svg.style.width = 2 * circleRadius + 'px';
            }


            setCircleIndicatorSizes();

            window.addEventListener( 'resize', () => {
                setCircleIndicatorSizes();
            } );

        }

        function updateScrollIndicator() {
            const height = document.documentElement.scrollHeight - window.innerHeight;
            circleIndicator.style.strokeDashoffset = circleLength - ( getTopOffset() * circleLength / height );
        }



        // scroll logic function
        function scroll ( scrollDuration ) {
            const target = scrollTo === 'top' ? 0 : document.getElementById( `${anchorId}` );
            if ( target !== null ) {
                const targetPosition = scrollTo === 'top' ? 0 : target.getBoundingClientRect().top + window.scrollY;
                const startPosition = window.pageYOffset;
                const scrollDistance = targetPosition - startPosition;
                let startTime = null;

                function scrollAnimation(currentTime) {
                    if (startTime === null) {
                        startTime = currentTime
                    }
                    const timeElapsed = currentTime - startTime;
                    const scrolling = scrollEasing === 'smooth' ? ease(timeElapsed, startPosition, scrollDistance, scrollDuration) :
                        scrollEasing === 'start-slowdown' ? acceleratingFromZeroVelocity(timeElapsed, startPosition, scrollDistance, scrollDuration)
                            : deceleratingToZeroVelocity(timeElapsed, startPosition, scrollDistance, scrollDuration);
                    window.scrollTo(0, scrolling);
                    if (timeElapsed < scrollDuration) requestAnimationFrame(scrollAnimation);
                }

                // slow down on start
                function acceleratingFromZeroVelocity(t, b, c, d) {
                    t /= d;
                    return c * t * t + b;
                }

                // slow down in the End
                function deceleratingToZeroVelocity(t, b, c, d) {
                    t /= d;
                    return -c * t * (t - 2) + b;
                }

                // smooth
                function ease(t, b, c, d) {
                    t /= d / 2;
                    if (t < 1) return c / 2 * t * t + b;
                    t--;
                    return -c / 2 * (t * (t - 2) - 1) + b;
                }

                requestAnimationFrame(scrollAnimation);
            }

        }

        $button.addEventListener( 'click', () => {
            scroll( +scrollSpeed * 1000 );
        } );

        function autoHideButton () {
            clearTimeout( timeout );
            timeout = setTimeout( () => {
                if ( !$button.classList.contains( 'mdp-uper-elementor-button-hide' ) ) {
                    $button.classList.add( 'mdp-uper-elementor-button-hide' );
                }
            },autoHideSeconds * 1000 );
        }

        $button.addEventListener( 'mouseenter', () => {
            $button.style.animation = `${buttonHoverAnimation} both`;
        } );

        $button.addEventListener( 'mouseleave', () => {
            $button.style.animation = '0';
        } );

        // displaying button logic
        function checkButtonDisplaying() {
            const autoHide = document.querySelector( `.${wrapperName}` ).dataset.autohide;
            if ( offsetType === 'custom-element' ) {
                const element = document.getElementById( customElementId );
                if ( element !== null ) {
                    const windowHeight = window.innerHeight;
                    if ( element.getBoundingClientRect().bottom <= ( windowHeight || document.documentElement.clientHeight ) ) {
                        $button.classList.remove( 'mdp-uper-elementor-button-hide' );
                        if ( autoHide !== undefined ) {
                            autoHideButton();
                        }
                    } else {
                        $button.classList.add( 'mdp-uper-elementor-button-hide' );
                        $button.style.animation = `${buttonAppearanceAnimation} both`;
                    }
                }
            } else {
                const topOffset = offsetType === 'percentage' ?
                    Math.floor( ( document.documentElement.scrollTop || document.body.scrollTop ) / ( ( document.documentElement.scrollHeight || document.body.scrollHeight ) - document.documentElement.clientHeight ) * 100 )
                    : getTopOffset();
                if ( topOffset >= offset ) {
                    $button.classList.remove( 'mdp-uper-elementor-button-hide' );
                    if ( autoHide !== undefined ) {
                        autoHideButton();
                    }
                } else {
                    $button.classList.add( 'mdp-uper-elementor-button-hide' );
                    $button.style.animation = `${buttonAppearanceAnimation} both`;
                }
            }
        }

        if ( offsetType !== 'always-show' && isFixed === 'yes' ) {
            $button.classList.add( 'mdp-uper-elementor-button-hide' );
            $button.style.animation = `${buttonAppearanceAnimation} both`;
            checkButtonDisplaying();
        } else {
            $button.classList.remove( 'mdp-uper-elementor-button-hide' );
            $button.style.animation = `${buttonAppearanceAnimation}`;
        }

        // scroll event
        if ( isScrollIndicator === 'yes' && isFixed === 'yes' ) {
            updateScrollIndicator();
        }

        window.addEventListener( 'scroll', () => {
            if ( offsetType !== 'always-show' && isFixed === 'yes' ) {
                checkButtonDisplaying();
            }
            if ( isScrollIndicator === 'yes' && isFixed === 'yes' ) {
                updateScrollIndicator()
            }
        } );
    },

    addUper: function () {

        const uperWrapper = document.querySelectorAll( '.mdp-uper-elementor-box' );

        for ( let i = 0; i < uperWrapper.length; i++ ) {
            uperWrapper[i].classList.add( 'mdp-uper-elementor-box-' + i );
            this.scrollTopButton( 'mdp-uper-elementor-box-' + i );
        }
    }

}


/**
 * Init for Front-End
 * @param callback
 */
document.addEventListener( 'DOMContentLoaded', mdpUper.addUper.bind( mdpUper ) );