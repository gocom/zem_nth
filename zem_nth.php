<?php

/**
 * Zem_nth plugin for Textpattern CMS.
 *
 * @author    Alex Shiels
 * @author    Jukka Svahn
 * @date      2013-
 * @license   GNU GPLv2
 * @link      https://github.com/gocom/zem_nth
 *
 * Copyright (C) 2013 Jukka Svahn http://rahforum.biz
 * Licensed under GNU Genral Public License version 2
 * http://www.gnu.org/licenses/gpl-2.0.html
 */

/**
 * Matches every nth item.
 *
 * @param  array  $atts
 * @param  string $thing
 * @return string
 */

	function zem_nth($atts, $thing = '')
	{
		static $counter = array(), $range = array();

		extract(lAtts(array(
			'step'  => 2,
			'of'    => PHP_INT_MAX,
			'id'    => null,
			'start' => 0,
			'reset' => 0,
		), $atts));

		if ($id === null)
		{
			$id = md5($step . $thing . $of);
		}

		if (!isset($range[$id]))
		{
			$range[$id] = array();

			// Expands a list of "1, 2, 3-7, 8" into an array of integers.

			foreach (do_list($step, ',') as $value)
			{
				if (strpos($value, '-'))
				{
					$value = do_list($value, '-');
					$range[$id] = array_merge($range[$id], range((int) $value[0], (int) $value[1]));
				}
				else
				{
					$range[$id][] = (int) $value;
				}
			}
		}

		if (!isset($counter[$id]) || $reset)
		{
			$counter[$id] = (int) $start;
		}

		$counter[$id]++;
		$out = parse(EvalElse($thing, in_array($counter[$id], $range[$id])));
		$counter[$id] = $counter[$id] % $of;

		return $out;
	}