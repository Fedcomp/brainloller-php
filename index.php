<?php
require 'brainloller.class.php';
require 'brainfuck.class.php';

$brainloller = new BrainLoller('hello-world.png');
$brainfuck = new Brainfuck($brainloller->getCode(), 1);
$brainfuck->run();
