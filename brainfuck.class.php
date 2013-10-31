<?php
/**
 * BrainfuckInterpreter
 *
 * This is another implementation of interpreter for Brainfuck.
 * The brainfuck programming language is an esoteric programming language
 * noted for its extreme minimalism. It is a Turing tarpit, designed
 * to challenge and amuse programmers, and is not suitable for practical use.
 *
 * @package BrainfuckInterpreter
 * @author  dZ <mail@dotzero.ru>
 * @version 1.0 (6-feb-2011)
 * @link    http://dotzero.ru
 * @link    https://github.com/dotzero/BrainfuckInterpreter/
 */
class Brainfuck
{
    /**
     * Source code & pointer
     */
    private $code = NULL;
    private $code_pointer = 0;

    /**
     * Data cells & pointer
     */
    private $cells = array();
    private $pointer = 0;

    /**
     * User input & pointer
     */
    private $input = NULL;
    private $input_pointer = 0;

    /**
     * Stack
     */
    private $buffer = array();

    /**
     * @param string $code
     * @param string $input
     */
    public function __construct($code, $input = FALSE)
    {
        $this->code = $code;
        $this->input = ($input) ? $input : FALSE;
    }

    /**
     * Execute interpreter
     */
    public function run()
    {
        while($this->code_pointer < strlen($this->code))
        {
            $this->interpret($this->code[$this->code_pointer]);
            $this->code_pointer++;
        }
    }

    /**
     * Commands interpreter
     *
     * @param string $command
     */
    private function interpret($command)
    {
        switch ($command)
        {
            case '>' :
                $this->pointer++;
                break;
            case '<' :
                $this->pointer--;
                break;
            case '+' :
                @$this->cells[$this->pointer]++;
                break;
            case '-' :
                $this->cells[$this->pointer]--;
                break;
            case '.' :
                echo chr($this->cells[$this->pointer]);
                break;
            case ',' :
                $this->cells[$this->pointer] = ord($this->input[$this->imput_pointer++]);
                break;
            case '[' :
                if($this->cells[$this->pointer] == 0)
                {
                    $delta = 1;
                    while($delta AND $this->code_pointer++ < strlen($this->code))
                    {
                        switch ($this->code[$this->code_pointer])
                        {
                            case '[' : $delta++; break;
                            case ']' : $delta--; break;
                        }
                    }
                }
                else
                {
                    $this->buffer[] = $this->code_pointer;
                }
                break;
            case ']' :
                $this->code_pointer = array_pop($this->buffer) - 1;
        }
    }
}
