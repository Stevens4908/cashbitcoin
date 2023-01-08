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

window.addEventListener( 'DOMContentLoaded', (event) => {

    /**
     * Add to the grid third element if needed
     */
    function arrangeGrid() {

        const grids = document.querySelectorAll( '.mdp-selection-grid' );
        const isTriple = window.innerWidth > 1280;

        for ( const grid of grids ) {

            const gridItems = grid.querySelectorAll( '.mdp-selection-widget' );
            const twoInRow = ( ( gridItems.length / 3 ) - Math.floor( gridItems.length / 3 ) ) > 0.65;

            if ( isTriple && twoInRow ) {

                const emptyDiv = document.createElement( 'div' );
                emptyDiv.className = 'mdp-selection-widget mdp-empty';

                grid.appendChild( emptyDiv );

            }

        }

    }

    /** Init function */
    arrangeGrid();

});