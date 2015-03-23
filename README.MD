# brainloller implementation written in php
Brainloller is a Brainfuck clone designed by Lode Vandevenne in 2005.
Commands are read from the pixels of a .png image, with 2 extra commands.
The extra commands change the instruction pointer direction so that you
can compact the 1D Brainfuck code into a 2D image. [More info](http://esolangs.org/wiki/Brainloller)

Brainloller class uses https://github.com/deralex/phprainfuck as dev-depedency,
allowing you to evaluate brainloller code.

## How to use
using [Composer](https://getcomposer.org/)
add requirement to your composer.json file
```
{
	"require":{
		"fedcomp/brainloller": "0.0.1"
	}
}
```
or run from console `composer require fedcomp/brainloller`

Then a bit of code and you are done
```php
<?php require_once __DIR__.'/vendor/autoload.php';

use Fedcomp\BrainLoller;
$brainloller = new BrainLoller();

$brainloller->init(__DIR__.'/tests/images/hello-world.png');
// OR
$brainloller->init(fopen(__DIR__.'/tests/images/hello-world.png', 'r'));
echo $brainloller->getCode();
```

Method `init()` accept file paths, file handles (`fopen()`), and gd handles (not tested).

Open example.php for more details.
