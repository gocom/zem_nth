<?php

/**
 * Zem_nth plugin for Textpattern CMS.
 *
 * @author    Alex Shiels
 * @author    Jukka Svahn
 * @date      2012-
 * @license   GNU GPLv2
 * @link      https://github.com/gocom/zem_nth
 *
 * Copyright (C) 2013 Jukka Svahn http://rahforum.biz
 * Licensed under GNU Genral Public License version 2
 * http://www.gnu.org/licenses/gpl-2.0.html
 */

	function zem_nth($atts, $thing = '')
	{
		static $counter = array();

		extract(lAtts(array(
			'step' => 2,
			'of'   => PHP_INT_MAX,
			'id'   => null,
		)));

		if ($id === null)
		{
			$id = md5($step . $thing . $of);
		}

		// Expands a list of "1, 2, 3-7, 8" into an array of integers.

		$range = array();

		foreach (do_list($step, ',') as $value)
		{
			if (strpos($value, '-'))
			{
				$value = do_list($value, '-');
				$range = array_merge($range, range((int) $value[0], (int) $value[1]));
			}
			else
			{
				$range[] = (int) $value;
			}
		}

		if (!isset($counter[$id]))
		{
			$counter[$id] = 0;
		}

		$counter[$id]++;
		$out = parse(EvalElse($thing, in_array($counter[$id], $range)));

		$counter[$id] = $counter[$id] % $of;
		return $out;
	}