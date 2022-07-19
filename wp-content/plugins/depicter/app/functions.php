<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


function depicter( $documentID  = null, $echo = true ) {

	$result = __( 'Slider not found.', 'depicter' );
	if ( empty( $documentID ) ) {
        echo esc_html( $result );
    }

    if ( is_string( $documentID ) ) {
        if ( ! $document = \Depicter::document()->repository()->findOne( null, ['slug' => $documentID] ) ) {
            echo esc_html( $result );
        }
        $documentID = $document->getID();
    }

    try{
        $result = \Depicter::front()->render()->document( $documentID, ['useCache' => true] );
    } catch( \Exception $e ){}

	if ( $echo ) {
        echo \Averta\WordPress\Utility\Sanitize::html( $result, null, 'depicter/output' );
    } else {
        return \Averta\WordPress\Utility\Sanitize::html( $result, null, 'depicter/output' );
    }
}
