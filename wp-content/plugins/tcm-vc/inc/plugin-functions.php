<?php 
	function randomNumber( $length) {
		$random   = '';
		while( !( isset( $random[$length-1] ) ) ) {
			$random   .= mt_rand( );
		}
		return substr( $random , 0 , $length );
	}		

