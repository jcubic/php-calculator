<?php

require_once __DIR__ . '/vendor/autoload.php';

use hafriedlander\Peg\Parser;

class Calculator extends Parser\Basic {

/* Number: /[0-9]+/ */
protected $match_Number_typestack = ['Number'];
function match_Number($stack = []) {
	$matchrule = 'Number';
	$this->currentRule = $matchrule;
	$result = $this->construct($matchrule, $matchrule);
	if (($subres = $this->rx('/[0-9]+/')) !== \false) {
		$result["text"] .= $subres;
		return $this->finalise($result);
	}
	else { return \false; }
}


/* Value: Number > | '(' > Expr > ')' > */
protected $match_Value_typestack = ['Value'];
function match_Value($stack = []) {
	$matchrule = 'Value';
	$this->currentRule = $matchrule;
	$result = $this->construct($matchrule, $matchrule);
	$_14 = \null;
	do {
		$res_1 = $result;
		$pos_1 = $this->pos;
		$_4 = \null;
		do {
			$key = 'match_'.'Number'; $pos = $this->pos;
			$subres = $this->packhas($key, $pos)
				? $this->packread($key, $pos)
				: $this->packwrite($key, $pos, $this->{$key}(\array_merge($stack, [$result])));
			if ($subres !== \false) { $this->store($result, $subres); }
			else { $_4 = \false; break; }
			if (($subres = $this->whitespace()) !== \false) { $result["text"] .= $subres; }
			$_4 = \true; break;
		}
		while(\false);
		if($_4 === \true) { $_14 = \true; break; }
		$result = $res_1;
		$this->setPos($pos_1);
		$_12 = \null;
		do {
			if (\substr($this->string, $this->pos, 1) === '(') {
				$this->addPos(1);
				$result["text"] .= '(';
			}
			else { $_12 = \false; break; }
			if (($subres = $this->whitespace()) !== \false) { $result["text"] .= $subres; }
			$key = 'match_'.'Expr'; $pos = $this->pos;
			$subres = $this->packhas($key, $pos)
				? $this->packread($key, $pos)
				: $this->packwrite($key, $pos, $this->{$key}(\array_merge($stack, [$result])));
			if ($subres !== \false) { $this->store($result, $subres); }
			else { $_12 = \false; break; }
			if (($subres = $this->whitespace()) !== \false) { $result["text"] .= $subres; }
			if (\substr($this->string, $this->pos, 1) === ')') {
				$this->addPos(1);
				$result["text"] .= ')';
			}
			else { $_12 = \false; break; }
			if (($subres = $this->whitespace()) !== \false) { $result["text"] .= $subres; }
			$_12 = \true; break;
		}
		while(\false);
		if($_12 === \true) { $_14 = \true; break; }
		$result = $res_1;
		$this->setPos($pos_1);
		$_14 = \false; break;
	}
	while(\false);
	if($_14 === \true) { return $this->finalise($result); }
	if($_14 === \false) { return \false; }
}

public function Value_Number ( &$result, $sub ) {
		$result['val'] = $sub['text'] ;
	}

public function Value_Expr ( &$result, $sub ) {
		$result['val'] = $sub['val'] ;
	}

/* Times: '*' > operand:Value > */
protected $match_Times_typestack = ['Times'];
function match_Times($stack = []) {
	$matchrule = 'Times';
	$this->currentRule = $matchrule;
	$result = $this->construct($matchrule, $matchrule);
	$_20 = \null;
	do {
		if (\substr($this->string, $this->pos, 1) === '*') {
			$this->addPos(1);
			$result["text"] .= '*';
		}
		else { $_20 = \false; break; }
		if (($subres = $this->whitespace()) !== \false) { $result["text"] .= $subres; }
		$key = 'match_'.'Value'; $pos = $this->pos;
		$subres = $this->packhas($key, $pos)
			? $this->packread($key, $pos)
			: $this->packwrite($key, $pos, $this->{$key}(\array_merge($stack, [$result])));
		if ($subres !== \false) {
			$this->store($result, $subres, "operand");
		}
		else { $_20 = \false; break; }
		if (($subres = $this->whitespace()) !== \false) { $result["text"] .= $subres; }
		$_20 = \true; break;
	}
	while(\false);
	if($_20 === \true) { return $this->finalise($result); }
	if($_20 === \false) { return \false; }
}


/* Div: '/' > operand:Value > */
protected $match_Div_typestack = ['Div'];
function match_Div($stack = []) {
	$matchrule = 'Div';
	$this->currentRule = $matchrule;
	$result = $this->construct($matchrule, $matchrule);
	$_26 = \null;
	do {
		if (\substr($this->string, $this->pos, 1) === '/') {
			$this->addPos(1);
			$result["text"] .= '/';
		}
		else { $_26 = \false; break; }
		if (($subres = $this->whitespace()) !== \false) { $result["text"] .= $subres; }
		$key = 'match_'.'Value'; $pos = $this->pos;
		$subres = $this->packhas($key, $pos)
			? $this->packread($key, $pos)
			: $this->packwrite($key, $pos, $this->{$key}(\array_merge($stack, [$result])));
		if ($subres !== \false) {
			$this->store($result, $subres, "operand");
		}
		else { $_26 = \false; break; }
		if (($subres = $this->whitespace()) !== \false) { $result["text"] .= $subres; }
		$_26 = \true; break;
	}
	while(\false);
	if($_26 === \true) { return $this->finalise($result); }
	if($_26 === \false) { return \false; }
}


/* Product: Value > ( Times | Div ) * */
protected $match_Product_typestack = ['Product'];
function match_Product($stack = []) {
	$matchrule = 'Product';
	$this->currentRule = $matchrule;
	$result = $this->construct($matchrule, $matchrule);
	$_37 = \null;
	do {
		$key = 'match_'.'Value'; $pos = $this->pos;
		$subres = $this->packhas($key, $pos)
			? $this->packread($key, $pos)
			: $this->packwrite($key, $pos, $this->{$key}(\array_merge($stack, [$result])));
		if ($subres !== \false) { $this->store($result, $subres); }
		else { $_37 = \false; break; }
		if (($subres = $this->whitespace()) !== \false) { $result["text"] .= $subres; }
		while (\true) {
			$res_36 = $result;
			$pos_36 = $this->pos;
			$_35 = \null;
			do {
				$_33 = \null;
				do {
					$res_30 = $result;
					$pos_30 = $this->pos;
					$key = 'match_'.'Times'; $pos = $this->pos;
					$subres = $this->packhas($key, $pos)
						? $this->packread($key, $pos)
						: $this->packwrite($key, $pos, $this->{$key}(\array_merge($stack, [$result])));
					if ($subres !== \false) {
						$this->store($result, $subres);
						$_33 = \true; break;
					}
					$result = $res_30;
					$this->setPos($pos_30);
					$key = 'match_'.'Div'; $pos = $this->pos;
					$subres = $this->packhas($key, $pos)
						? $this->packread($key, $pos)
						: $this->packwrite($key, $pos, $this->{$key}(\array_merge($stack, [$result])));
					if ($subres !== \false) {
						$this->store($result, $subres);
						$_33 = \true; break;
					}
					$result = $res_30;
					$this->setPos($pos_30);
					$_33 = \false; break;
				}
				while(\false);
				if($_33 === \false) { $_35 = \false; break; }
				$_35 = \true; break;
			}
			while(\false);
			if($_35 === \false) {
				$result = $res_36;
				$this->setPos($pos_36);
				unset($res_36, $pos_36);
				break;
			}
		}
		$_37 = \true; break;
	}
	while(\false);
	if($_37 === \true) { return $this->finalise($result); }
	if($_37 === \false) { return \false; }
}

public function Product_Value ( &$result, $sub ) {
		$result['val'] = $sub['val'] ;
	}

public function Product_Times ( &$result, $sub ) {
		$result['val'] *= $sub['operand']['val'] ;
	}

public function Product_Div ( &$result, $sub ) {
		$result['val'] /= $sub['operand']['val'] ;
	}

/* Plus: '+' > operand:Product > */
protected $match_Plus_typestack = ['Plus'];
function match_Plus($stack = []) {
	$matchrule = 'Plus';
	$this->currentRule = $matchrule;
	$result = $this->construct($matchrule, $matchrule);
	$_43 = \null;
	do {
		if (\substr($this->string, $this->pos, 1) === '+') {
			$this->addPos(1);
			$result["text"] .= '+';
		}
		else { $_43 = \false; break; }
		if (($subres = $this->whitespace()) !== \false) { $result["text"] .= $subres; }
		$key = 'match_'.'Product'; $pos = $this->pos;
		$subres = $this->packhas($key, $pos)
			? $this->packread($key, $pos)
			: $this->packwrite($key, $pos, $this->{$key}(\array_merge($stack, [$result])));
		if ($subres !== \false) {
			$this->store($result, $subres, "operand");
		}
		else { $_43 = \false; break; }
		if (($subres = $this->whitespace()) !== \false) { $result["text"] .= $subres; }
		$_43 = \true; break;
	}
	while(\false);
	if($_43 === \true) { return $this->finalise($result); }
	if($_43 === \false) { return \false; }
}


/* Minus: '-' > operand:Product > */
protected $match_Minus_typestack = ['Minus'];
function match_Minus($stack = []) {
	$matchrule = 'Minus';
	$this->currentRule = $matchrule;
	$result = $this->construct($matchrule, $matchrule);
	$_49 = \null;
	do {
		if (\substr($this->string, $this->pos, 1) === '-') {
			$this->addPos(1);
			$result["text"] .= '-';
		}
		else { $_49 = \false; break; }
		if (($subres = $this->whitespace()) !== \false) { $result["text"] .= $subres; }
		$key = 'match_'.'Product'; $pos = $this->pos;
		$subres = $this->packhas($key, $pos)
			? $this->packread($key, $pos)
			: $this->packwrite($key, $pos, $this->{$key}(\array_merge($stack, [$result])));
		if ($subres !== \false) {
			$this->store($result, $subres, "operand");
		}
		else { $_49 = \false; break; }
		if (($subres = $this->whitespace()) !== \false) { $result["text"] .= $subres; }
		$_49 = \true; break;
	}
	while(\false);
	if($_49 === \true) { return $this->finalise($result); }
	if($_49 === \false) { return \false; }
}


/* Sum: Product > ( Plus | Minus ) * */
protected $match_Sum_typestack = ['Sum'];
function match_Sum($stack = []) {
	$matchrule = 'Sum';
	$this->currentRule = $matchrule;
	$result = $this->construct($matchrule, $matchrule);
	$_60 = \null;
	do {
		$key = 'match_'.'Product'; $pos = $this->pos;
		$subres = $this->packhas($key, $pos)
			? $this->packread($key, $pos)
			: $this->packwrite($key, $pos, $this->{$key}(\array_merge($stack, [$result])));
		if ($subres !== \false) { $this->store($result, $subres); }
		else { $_60 = \false; break; }
		if (($subres = $this->whitespace()) !== \false) { $result["text"] .= $subres; }
		while (\true) {
			$res_59 = $result;
			$pos_59 = $this->pos;
			$_58 = \null;
			do {
				$_56 = \null;
				do {
					$res_53 = $result;
					$pos_53 = $this->pos;
					$key = 'match_'.'Plus'; $pos = $this->pos;
					$subres = $this->packhas($key, $pos)
						? $this->packread($key, $pos)
						: $this->packwrite($key, $pos, $this->{$key}(\array_merge($stack, [$result])));
					if ($subres !== \false) {
						$this->store($result, $subres);
						$_56 = \true; break;
					}
					$result = $res_53;
					$this->setPos($pos_53);
					$key = 'match_'.'Minus'; $pos = $this->pos;
					$subres = $this->packhas($key, $pos)
						? $this->packread($key, $pos)
						: $this->packwrite($key, $pos, $this->{$key}(\array_merge($stack, [$result])));
					if ($subres !== \false) {
						$this->store($result, $subres);
						$_56 = \true; break;
					}
					$result = $res_53;
					$this->setPos($pos_53);
					$_56 = \false; break;
				}
				while(\false);
				if($_56 === \false) { $_58 = \false; break; }
				$_58 = \true; break;
			}
			while(\false);
			if($_58 === \false) {
				$result = $res_59;
				$this->setPos($pos_59);
				unset($res_59, $pos_59);
				break;
			}
		}
		$_60 = \true; break;
	}
	while(\false);
	if($_60 === \true) { return $this->finalise($result); }
	if($_60 === \false) { return \false; }
}

public function Sum_Product ( &$result, $sub ) {
		$result['val'] = $sub['val'] ;
	}

public function Sum_Plus ( &$result, $sub ) {
		$result['val'] += $sub['operand']['val'] ;
	}

public function Sum_Minus ( &$result, $sub ) {
		$result['val'] -= $sub['operand']['val'] ;
	}

/* Expr: Sum */
protected $match_Expr_typestack = ['Expr'];
function match_Expr($stack = []) {
	$matchrule = 'Expr';
	$this->currentRule = $matchrule;
	$result = $this->construct($matchrule, $matchrule);
	$key = 'match_'.'Sum'; $pos = $this->pos;
	$subres = $this->packhas($key, $pos)
		? $this->packread($key, $pos)
		: $this->packwrite($key, $pos, $this->{$key}(\array_merge($stack, [$result])));
	if ($subres !== \false) {
		$this->store($result, $subres);
		return $this->finalise($result);
	}
	else { return \false; }
}

public function Expr_Sum ( &$result, $sub ) {
		$result['val'] = $sub['val'] ;
	}



}

$x = new Calculator('-8(1/2)') ;
$res = $x->match_Expr() ;
if ( $res === FALSE ) {
	print "No Match\n" ;
}
else {
	print_r( $res ) ;
}
