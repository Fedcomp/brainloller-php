<?php require_once __DIR__.'/vendor/autoload.php';

use Fedcomp\BrainLoller;
use DerAlex\Phprainfuck\Phprainfuck;

$brainloller    = new BrainLoller();
$brainfuck      = new Phprainfuck();

$brainloller->init(__DIR__.'/tests/images/hello-world.png');
echo $brainfuck->evaluate( $brainloller->getCode() );