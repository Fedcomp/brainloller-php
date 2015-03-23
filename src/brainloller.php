<?php

namespace Fedcomp;

/**
 * Class BrainLoller
 * @package Fedcomp
 */
class BrainLoller {
    const DIRECTION_UP      = 0;
    const DIRECTION_RIGHT   = 1;
    const DIRECTION_DOWN    = 2;
    const DIRECTION_LEFT    = 3;

    /**
     * @var array with direction operations
     */
    protected $directions = [
        [ 0,-1],
        [ 1, 0],
        [ 0, 1],
        [-1, 0]
    ];

    /**
     * @var array list hex_color => brainfuck_command char representation
     */
    protected $commands = [
        0x00FF00 => '+',
        0x008000 => '-',
        0xFF0000 => '>',
        0x800000 => '<',
        0xFFFF00 => '[',
        0x808000 => ']',
        0x0000FF => '.',
        0x000080 => ','
    ];

    /**
     * @var resource  GD context for this class
     */
    protected $picture;

    /**
     * @var int height of brainloller image
     */
    protected $height;

    /**
     * @var int width of brainloller image
     */
    protected $width;

    /**
     * @var bool
     */
    protected $initialized  = False;

    /**
     * @param $node string|resource   path to image, stream with picture or GD created context.
     */
    public function init($node){
        // Order matters, resource check first
        if(is_resource($node)){
            if(get_resource_type( $node ) == 'stream'){
                $contents = '';
                while (!feof($node)) $contents .= fread($node, 8192);
                if(substr($contents, 1, strlen('PNG')) !== 'PNG') throw new \InvalidArgumentException('Invalid brainloller image: Not a PNG file');
                $contents = 'data://image/png;base64,' . base64_encode($contents);
                $this->picture = imagecreatefrompng($contents);
            }
            elseif(get_resource_type( $node ) == 'gd')  $this->picture = $node;
            else                                        throw new \InvalidArgumentException('Unsupported resource type: '.get_resource_type( $node ));
        }
        elseif(is_file($node)) $this->picture = imagecreatefrompng($node);
        else throw new \InvalidArgumentException('Invalid argument specified as brainloller image');

        $this->width = imagesx($this->picture);
        $this->height = imagesy($this->picture);
        $this->initialized = True;

        return $this;
    }

    /**
     * Reads the code from image
     *
     * @return string brainfuck code
     * @throws \Exception
     */
    public function getCode(){
        if(!$this->initialized) throw new \Exception('Initialize brainloller image first.');

        $buffer = '';
        $position = [0,0];
        $pointer = self::DIRECTION_RIGHT;

        while(self::inBounds($position, $this->width, $this->height)){
            $color = imagecolorat($this->picture, $position[0], $position[1]);
            $color &= 0xFFFFFF;

            if (isset($this->commands[$color]))
                $buffer .= $this->commands[$color];
            elseif ($color == 0x00FFFF)
                $pointer = ($pointer + 1) % 4;
            elseif ($color == 0x008080)
                $pointer = ($pointer - 1 + 4) % 4;

            $position[0] += $this->directions[$pointer][0];
            $position[1] += $this->directions[$pointer][1];
        }
        return $buffer;
    }

    /**
     * @param array $position [0,0] X,Y with current position
     * @param int $width of the box
     * @param int $height of the box
     * @return bool
     */
    protected static function inBounds($position, $width, $height){
        return(
            $position[0] <= $width    AND
            $position[1] <= $height   AND
            $position[0] >= 0         AND
            $position[1] >= 0
        );
    }

    /**
     *  Pretty much self explanatory (:
     */
    function __destruct(){
        if($this->initialized) imagedestroy($this->picture);
    }
}