<?php

require_once __DIR__ . '/vendor/autoload.php';

use hafriedlander\Peg\Parser;

class Calculator extends Parser\Basic {

/*!* Calculator

Number: /[0-9]+/
Value: Number > | '(' > Expr > ')' >
	function Number( &$result, $sub ) {
		$result['val'] = $sub['text'] ;
	}
	function Expr( &$result, $sub ) {
		$result['val'] = $sub['val'] ;
	}

Times: '*' > operand:Value >
Div: '/' > operand:Value >
Product: Value > ( Times | Div ) *
	function Value( &$result, $sub ) {
		$result['val'] = $sub['val'] ;
	}
	function Times( &$result, $sub ) {
		$result['val'] *= $sub['operand']['val'] ;
	}
	function Div( &$result, $sub ) {
		$result['val'] /= $sub['operand']['val'] ;
	}

Plus: '+' > operand:Product >
Minus: '-' > operand:Product >
Sum: Product > ( Plus | Minus ) *
	function Product( &$result, $sub ) {
		$result['val'] = $sub['val'] ;
	}
	function Plus( &$result, $sub ) {
		$result['val'] += $sub['operand']['val'] ;
	}
	function Minus( &$result, $sub ) {
		$result['val'] -= $sub['operand']['val'] ;
	}

Expr: Sum
	function Sum( &$result, $sub ) {
		$result['val'] = $sub['val'] ;
	}

*/

}

$x = new Calculator('-8(1/2)') ;
$res = $x->match_Expr() ;
if ( $res === FALSE ) {
	print "No Match\n" ;
}
else {
	print_r( $res ) ;
}
