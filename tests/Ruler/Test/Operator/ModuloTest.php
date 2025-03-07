<?php

namespace Ruler\Test\Operator;

use Ruler\Operator;
use Ruler\Context;
use Ruler\Variable;
use PHPUnit\Framework\TestCase;

class ModuloTest extends TestCase
{
    public function testInterface()
    {
        $varA = new Variable('a', 1);
        $varB = new Variable('b', array(2));

        $op = new Operator\Modulo($varA, $varB);
        $this->assertInstanceOf('Ruler\\VariableOperand', $op);
    }

    public function testInvalidData()
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Arithmetic: values must be numeric');
        $varA    = new Variable('a', "string");
        $varB    = new Variable('b', "blah");
        $context = new Context();

        $op = new Operator\Modulo($varA, $varB);
        $op->prepareValue($context);
    }

    public function testDivideByZero()
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Division by zero');
        $varA    = new Variable('a', rand(1, 100));
        $varB    = new Variable('b', 0);
        $context = new Context();

        $op = new Operator\Modulo($varA, $varB);
        $op->prepareValue($context);
    }

    /**
     * @dataProvider moduloData
     */
    public function testModulo($a, $b, $result)
    {
        $varA    = new Variable('a', $a);
        $varB    = new Variable('b', $b);
        $context = new Context();

        $op = new Operator\Modulo($varA, $varB);
        $this->assertEquals($op->prepareValue($context)->getValue(), $result);
    }

    public function moduloData()
    {
        return array(
            array(6, 2, 0),
            array(7, 3, 1),
        );
    }
}
