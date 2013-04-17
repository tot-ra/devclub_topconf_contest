<?php
/**
 * @author Artjom Kurapov
 */

class NaturalRowOffsetTest extends PHPUnit_Framework_TestCase{

	/** construct */
	public function setUp(){
		require_once 'NaturalRowGenerator.php';
	}


	/** @test */
	public function positionAt0(){
		$this->assertEquals(null, getDigitAtNaturalRow(0));
	}

	/** @test */
	public function positionAt1(){
		$this->assertEquals(1, getDigitAtNaturalRow(1));
	}

	/** @test */
	public function positionAt8(){
		$this->assertEquals(8, getDigitAtNaturalRow(8));
	}


	/** @test */
	public function positionAt9(){
		$this->assertEquals(9, getDigitAtNaturalRow(9));
	}

	/** @test */
	public function positionAt10(){
		$this->assertEquals(1, getDigitAtNaturalRow(10));
	}

	/** @test */
	public function positionAt11(){
		$this->assertEquals(0, getDigitAtNaturalRow(11));
	}

	/** @test */
	public function positionAt17(){
		$this->assertEquals(3, getDigitAtNaturalRow(17));
	}

	/** @test */
	public function positionAt188(){
		$this->assertEquals(9, getDigitAtNaturalRow(188));
	}
	/** @test */
	public function positionAt189(){
		$this->assertEquals(9, getDigitAtNaturalRow(189));
	}

	/** @test */
	public function positionAt190(){
		$this->assertEquals(1, getDigitAtNaturalRow(190));
	}

	/** @test */
	public function positionAt117(){
		$this->assertEquals(1, getDigitAtNaturalRow(117));
	}


	/** @test */
	public function positionAt200k(){
		$start_time = time();
		$start_memory = memory_get_peak_usage();

		$this->assertEquals(4, getDigitAtNaturalRow(200000));

		$this->assertLessThan(1, (time()-$start_time));
		$this->assertLessThan(30000, (memory_get_peak_usage() - $start_memory));
	}

	/** @test */
	public function positionAt280k(){
		$start_time = time();
		$start_memory = memory_get_peak_usage();

		$this->assertEquals(5, getDigitAtNaturalRow(280000));

		$this->assertLessThan(1, (time()-$start_time));
		$this->assertLessThan(30000, (memory_get_peak_usage() - $start_memory));
	}

	/** @test */
	public function positionAtAlot(){
		$start_time = time();
		$start_memory = memory_get_peak_usage();

		$this->assertEquals(2, getDigitAtNaturalRow('1000000005000000000'));

		$this->assertLessThan(11, (time()-$start_time));
		$this->assertLessThan(8000000, (memory_get_peak_usage() - $start_memory));
	}


//	/** @test */
//	public function startPositionTo9(){
//		$this->assertEquals( array(1,0, 1), getFirstApproximationPoint(5));
//	}
//
//	/** @test */
//	public function startPositionTo99(){
//		$this->assertEquals( array(10,9, 2), getFirstApproximationPoint(50));
//	}
//
//	/** @test */
//	public function startPositionTo999(){
//		$this->assertEquals( array(100,107, 3), getFirstApproximationPoint(230));
//	}
}
