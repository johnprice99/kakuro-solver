<?php

class PermutationCalculator {

	private $_available = array(1, 2, 3, 4, 5, 6, 7, 8, 9);

	public function calculate($value, $in) {
		if ($in === 2) {
			$results = array();

			// clear out any numbers which are too large
			$available = $this->_available;
			array_splice($available, $value - 1);
			$reverse = array_reverse($available);

			//now loop through each available number
			$k = 0;
			while ($k <= count($available)) {
				$i = $available[$k];

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

				$k++;
			}
		}
		else {
			$results = array();

			// clear out any numbers which are too large
			$available = $this->_available;
			array_splice($available, $value - 1);

			//now loop through each available number
			$k = 0;
			while ($k <= count($available)) {

				$i = $available[$k];


				if ($i != '') {

					$target = $value - $i;

					$targetIn2 = $this->calculate($target, $in-1);

					foreach ($targetIn2 as $r) {
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

				$k++;
			}
		}

		return $results;
	}
}


$calc = new PermutationCalculator();
print_r($calc->calculate(11, 2));
die();