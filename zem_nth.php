<?php

	function zem_nth($atts, $thing) {
		global $zem_nth_count;
		$step = (empty($atts["step"]) ? 2 : $atts["step"]);
		# aside: can you believe PHP has no INT_MAX equivalent?
		$of = (empty($atts["of"]) ? 1000000 : $atts["of"]);

		# parse a list of the form "1, 2, 3-7, 8" into an array of integers
		$range = array();
		$r = explode(",", $step);
		foreach ($r as $i) {
			if (strpos($i, "-")) {
				list($low, $high) = explode("-", $i, 2);
				$range = array_merge($range, range($low, $high));
			}
			else {
				$range[] = (int)$i;
			}
		}

		# Keep separate counters for each zem_nth tag
		$id = md5($step. $thing . $of);

		if (!isset($zem_nth_count[$id]))
			$zem_nth_count[$id] = 0;

		$result = NULL;
		if (in_array($zem_nth_count[$id] + 1, $range))
			$result = parse($thing);

		$zem_nth_count[$id] = ($zem_nth_count[$id] +1) % $of;

		return $result;
	}