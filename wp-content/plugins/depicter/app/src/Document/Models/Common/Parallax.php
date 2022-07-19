<?php
namespace Depicter\Document\Models\Common;

use Averta\Core\Utility\Data;
use Averta\WordPress\Utility\JSON;
use Depicter\Document\CSS\Breakpoints;

class Parallax extends States{

	/**
	 * Get all parallax attributes
	 *
	 * @return array
	 */
	public function getParallaxAttrs() {
		$attrs = [];

		// Collect animation attributes
		foreach ( Breakpoints::names() as $breakpoint  ){
            $breakpoint_prefix = $breakpoint ? $breakpoint . '-' : $breakpoint;
            $breakpoint_prefix = $breakpoint == 'default' ? '' : $breakpoint_prefix;

			if( isset( $this->{$breakpoint}->enabled ) ){
                $attrs[ 'data-'.  $breakpoint_prefix .'parallax' ] = !empty($this->{$breakpoint}->enabled) ? $this->getParallaxOption( $this->{$breakpoint} ) : 'false';
			}

		}

		return $attrs;
	}

    /**
     * Get parallax option
     *
     * @param object $parallaxOptions
     * @return string
     */
    public function getParallaxOption( $parallaxOptions ) {
        $options['type'] = $parallaxOptions->type = $parallaxOptions->type ?? '2d';

        if ( $parallaxOptions->type === '2d' ) {
	        ! Data::isNullOrEmptyStr( $parallaxOptions->x ) && $options['x'] = $parallaxOptions->x;
            ! Data::isNullOrEmptyStr( $parallaxOptions->y ) && $options['y'] = $parallaxOptions->x;
        } elseif ( $parallaxOptions->type === '3d' ) {
	        ! Data::isNullOrEmptyStr( $parallaxOptions->x ) && $options['x'] = $parallaxOptions->x;
            ! Data::isNullOrEmptyStr( $parallaxOptions->y ) && $options['y'] = $parallaxOptions->y;
            ! Data::isNullOrEmptyStr( $parallaxOptions->rx ) && $options['rx'] = $parallaxOptions->rx;
            ! Data::isNullOrEmptyStr( $parallaxOptions->ry ) && $options['ry'] = $parallaxOptions->ry;
            ! Data::isNullOrEmptyStr( $parallaxOptions->zOrigin ) && $options['zOrigin'] = $parallaxOptions->zOrigin;
        } elseif (  $parallaxOptions->type == 'scroll' ||  $parallaxOptions->type == 'viewScroll' ) {
	        ! Data::isNullOrEmptyStr( $parallaxOptions->dir ) && $options['dir'] = $parallaxOptions->dir;
	        ! Data::isNullOrEmptyStr( $parallaxOptions->movement ) && $options['movement'] = $parallaxOptions->movement;
	        ! Data::isNullOrEmptyStr( $parallaxOptions->scale ) && $options['scale'] = $parallaxOptions->scale;
	        ! Data::isNullOrEmptyStr( $parallaxOptions->rotate ) && $options['rotate'] = $parallaxOptions->rotate;
	        // Add value for following params even if params are not set
			$options['fade']   = ! Data::isNullOrEmptyStr( $parallaxOptions->fade ) ? Data::isTrue( $parallaxOptions->fade ) : true;
			$options['twoWay'] = ! Data::isNullOrEmptyStr( $parallaxOptions->twoWay ) ? Data::isTrue( $parallaxOptions->twoWay ) : true;
        }

		$options['smooth'] = ! Data::isNullOrEmptyStr( $parallaxOptions->smooth ) ? Data::isTrue( $parallaxOptions->smooth ) : true;

        return JSON::encode( $options );
    }
}
