<?php


/**
 * Position to number transformation function
 *
 * Practical example, number at position 142:
 * 1..9 = 9
 * 10..99 = 89
 * 142-89-9 = 44 position after 100 (which is 3 digits in size)
 * 44/3 = 14 and 2/3, which makes it second number in 115, which is 1
 *
 * Generalization:
 * Takes into account that numeric row has dependency from digit size and 10-base
 * For example 1..9 is 1 size and length is 9
 * 10..99 is 2 in size and length is 89
 *
 * For some part of that row we also have subrow
 * x1..xn = 10^z - (len(z) + len(z-1)) = 10^z - (1+2+..z)
 *
 * And entire number at defined position is calculated from summing sizes of these subrows + remainder
 * So we sum rows 9+89+899 and that leaves us with a remainder which has the same digit size as last interval + 1,
 * for example for position 1500, digit size is 4 and remainder is 448
 *
 * Now we need to divide
 *
 * To go through the rest
 *
 * @param $positionEnd
 *
 * @return array
 * x - actual number
 * y - position or key of this number in natural row, for example $row[$y] but with regard to number size
 * step - digit-size of last number
 */
function getFirstApproximationPoint($positionEnd) {
	$numberPosition  = 0;
	$number          = 1;
	$numberDigitSize = 1;

	$numberJumpSize = $step = 0;
	//if($xEnd<10) return array($x, $y);
	//if($positionEnd<10) return array($positionEnd,$positionEnd-1,1,0);

	while($numberJumpSize < $positionEnd) {

		$numberJumpSize = bcpow(10, $step);
		$newNumPos = bcadd($numberPosition, bcsub($numberJumpSize,$numberDigitSize));
		if($newNumPos < $positionEnd) {
			$number = $numberJumpSize;
			$numberPosition = $newNumPos; //$numberPosition += $numberJumpSize - $numberDigitSize;
		}
		else {
			break;
		}


		$numberDigitSize = $step + 1;
		$step++;
		echo "\n increasing size to " . $step . " at " . $number;
	}

	$subStep = 0;
	print_r("\nnumberPosition".$numberPosition);
	print_r("\npositionEnd".$positionEnd);
	print_r("\nnumber:".$number);
	if($numberPosition < $positionEnd) {
		$remainingPosition = bcsub(bcsub($positionEnd,$numberPosition),1); //($positionEnd - $numberPosition)-1;
		$remainingFullX    = bcdiv($remainingPosition, $numberDigitSize, 0); // floor($remainingPosition/$numberDigitSize)
		print_r("\nremainingPosition:".$remainingPosition);
		print_r("\nremainingFullX:".$remainingFullX);
		$numberPosition    = bcadd($numberPosition, $remainingPosition);
		$number            = bcadd($number, $remainingFullX);

		$subStep = bcsub($remainingPosition, bcmul(bcdiv($remainingPosition, $numberDigitSize, 0), $numberDigitSize)); //($remainingPosition % $numberDigitSize);
		//$subStep = bcadd($subStep,1);
	}
print_r("\n subStep:".$subStep);
	return array($number, $numberPosition, $numberDigitSize, $subStep);
}


function getDigitAtNaturalRow($positionEnd) {
	if($positionEnd == 0) {
		return null;
	}
	if($positionEnd<10) return $positionEnd;
	echo "\nabsolute number position:" . $positionEnd;

	$numberPosition  = 1;
	$number          = 1;
	$numberDigitSize = 1;

	$numberJump = $step = 0;
	//if($positionEnd<10) return array($positionEnd,$positionEnd-1,1,0);


	//Iteratively increase number from 1 to 10, to 100, while calculating corresponding position start for it
	while($numberJump < $positionEnd) {

		$numberJump = bcpow(10, $step);
		echo "\nthinking of adding $numberJump * $numberDigitSize to current position ($numberPosition) ";
		$newNumPos = bcadd($numberPosition, bcmul($numberJump,$numberDigitSize));
		if($newNumPos <= $positionEnd) {
			$number = $numberJump;
			$numberPosition = $newNumPos; //$numberPosition += $numberJumpSize - $numberDigitSize;
		}
		else {
			break;
		}


		$numberDigitSize = $step + 1;
		$step++;
		echo "\nlooks like closest number is ".$number;
		echo "\nincreasing step size to " . $step;
	}

	$subStep = 0;
	print_r("\nnumberPosition:".$numberPosition);
	print_r("\npositionEnd".$positionEnd);
	print_r("\nnumber:".$number);
	if($numberPosition < $positionEnd) {
		$remainingPosition = bcsub($positionEnd,$numberPosition); //($positionEnd - $numberPosition)-1;
		$remainingFullX    = bcdiv($remainingPosition, $numberDigitSize, 0); // floor($remainingPosition/$numberDigitSize)
		print_r("\nremainingPosition:".$remainingPosition);
		print_r("\nremainingFullX:".$remainingFullX);
		$numberPosition    = bcadd($numberPosition, $remainingPosition);
		$number            = bcadd($number, $remainingFullX);

		$subStep = bcsub($remainingPosition, bcmul(bcdiv($remainingPosition, $numberDigitSize, 0), $numberDigitSize)); //($remainingPosition % $numberDigitSize);
		//$subStep = bcadd($subStep,1);
	}


	//return array($number, $numberPosition, $numberDigitSize, $subStep);
	//list($number, $numberStartPosition, $speed, $subStep) = getFirstApproximationPoint($finalPosition);

	//$address = $subStep;//bcadd(bcsub(bcsub($finalPosition, $numberStartPosition), 1), $subStep);
	$number     = (string)$number;


	echo "\nnumber:", $number;
	echo "\nat position:". $numberPosition;
	echo "\nwith offset:".$subStep;
	echo "\nrow:" . $number;
	echo "\n";

	return (int)$number[$subStep];
}


function generateNaturalRow($number, $starting_number = 1) {
	$row = '';
	for($x = $starting_number; $x <= $number; $x++) {
		$row = $row . (string)$x;
	}
	return $row;
}