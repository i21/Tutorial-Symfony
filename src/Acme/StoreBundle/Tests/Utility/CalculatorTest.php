<?php
// src/Acme/StoreBundle/Tests/Utility/CalculatorTest.php

namespace Acme\StoreBundle\Tests\Utility;

use Acme\StoreBundle\Utility\Calculator;

class CalculatorTest extends \PHPUnit_Framework_TestCase
{
	public function testAdd()
	{
		$calc = new Calculator();
		$result = $calc->add(30,12);

		// Right?!
		$this->assertEquals(42, $result);
	}
}