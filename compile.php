<?php
require_once __DIR__ . '/vendor/autoload.php';

$parser = \hafriedlander\Peg\Compiler::compile(file_get_contents('index.peg.php'));
file_put_contents('index.php', $parser);
