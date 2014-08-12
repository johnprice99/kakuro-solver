<?php

class KakuroCalculator {

	private $_available = array(1, 2, 3, 4, 5, 6, 7, 8, 9);

	public function getHighestPossibleNumber() {
		return array_sum($this->_available);
	}

	public function calculate($value, $in) {
		$results = array();

		// clear out any numbers which are too large
		$available = $this->_available;
		array_splice($available, $value - 1);
		$reverse = array_reverse($available);

		//now loop through each available number
		$k = 0;

		while ($k <= count($available)) {
			$i = $available[$k];

			if ($in == 2) { //this is the out for the recursive function
				//loop through each value in the reverse array
				foreach ($reverse as $j) {
					//compare the output added with the lowest number in the reverse array
					if (($i !== $j) && ($i + $j == $value)) {
						$results[] = array($i, $j);

						//remove this number from the list of numbers as it has already been used
						if(($unsetKey = array_search($j, $available)) !== false) {
							unset($available[$unsetKey]);
						}
					}
				}
			}
			else {
				if ($i != '') {
					$targetInLess = $this->calculate($value-$i, $in-1);

					foreach ($targetInLess as $r) {
						if(array_search($i, $r) !== false) {
							continue;
						}

						foreach ($r as $n) {
							if(($unsetKey = array_search($n, $available)) !== false) {
								unset($available[$unsetKey]);
							}
						}

						$r[] = $i;
						sort($r);
						$results[] = $r;
					}
				}
			}

			$k++;
		}

		return $results;
	}
}