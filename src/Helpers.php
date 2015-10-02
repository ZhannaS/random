<?php

namespace Finder;

/**
 * Class Helper contains most useful functions
 * for specific string conversions
 */

class Helpers
{
    
	/**
	 * If function has a name that is a PHP reserved word it is substituted 
	 * with another one defined within Helpers class
	 *
	 * @param string $name. Function name.
	 * @param array $arguments. Arguments passed to the original function 
	 * @return mixed 
	 */

	public function __call($name, $arguments)
    {
        $method_name = $name . '_finder';
		$result = $this->$method_name($arguments);
		
		return $result;
    }
	
	
	/**
	 * Function returns number of months and singular or plural of the word "month".
	 *
	 * @param integer $period. Number of months.
	 * @return string 
	 */
	
	public function months($period)
    {
        if(!is_numeric($period)) {
            return '';
        }

        return ($period == 1) ? "1 month" : "$period months";
    }

	
	/**
	 * Returns 'Yes', 'No' or an empty string depending on the passed argument. 
	 *
	 * @param integer|string $value. Value to convert
	 * @return string 
	 */
	
    public function yesNo($value)
    {
        if ($value == '0' || strtolower($value) == 'no') {
            return 'No';
        }
        if ($value == '1' || strtolower($value) == 'yes') {
            return 'Yes';
        }

        return '';
    }

	
	/**
	 * Returns formatted money string with 0 decimals if the original value is integer or with indicated number od deciamls otherwise. 
	 * The decimals are rounded down.
	 *
	 * @param integer|string|float $value. Number to convert
	 * @param integer $decimals Optional. Number of decimals wanted
	 * @return string 
	 */
	
    public function money($value, $decimals = 2)
    {
        if (!is_numeric($value) || !is_numeric($decimals)) {
            return $value;
        }
		if (is_int($value)) {
			$decimals = 0;
		}
		
        return '$' . number_format((floor($value*100))/100, $decimals, '.', ',');
    }
	
	
	/**
	 * Formats date using specified format and time zone if provided. 
	 * 24-hour format is forced to be used.
	 *
	 * @param string $data. Date to be converted
	 * @param string $format Optional. Pattern to use as format
	 * @param string $timezone Optional. Timezone to use
	 * @return string 
	 * @throws Exception If $data can't be converted 
	 */
	 
    public function date($data, $format = 'Y-m-d 12:00:00', $timezone = NULL)
    {
        try {
            $time = new \DateTime($data);
			if (!is_null($timezone)) {
				$time->setTimeZone(new \DateTimeZone($timezone));
			}

        }
        catch(Exception $e) {
            return $data;
        }
		 $format = str_replace('h', 'H', $format);
		
        return $time->format($format);
    }

	
	/**
	 * Returns string containing number of units singular or plural
	 *
	 * @param integer $data. Number of months.
	 * @param string $unit. The word to return in singular or plural
	 * @return string 
	 */

    public function pluralize($data, $unit)
    {
        if (!is_numeric($data)) {
            return $data;
        }
        if ($data == 1) {
            return sprintf('%s %s', $data, $unit);
        } else {
            return sprintf('%s %ss', $data, $unit);
        }
    }
	
	
	/**
	 * Returns string where element are listed like in speaking 
	 * divided by commas and the 'and' word before the last element
	 *
	 * @param array $arguments. Array of words.
	 * @return string 
	 */
	
	public function list_finder($arguments)
	{
		$arg = $arguments[0];
		if (count($arg) == 1) {
			$result = $arg[0];
		} else {
			$subresult = ' and ' . $arg[count($arg)-1];
			array_pop($arg);
			$result = implode(', ', $arg) . $subresult;
		}
		
		return $result;
		
	}
	
	
	/**
	 * Converts number to indicated currency using '.' as decimal separator
	 * and ',' as thousands separator
	 *
	 * @param integer $amount. Currency amount
	 * @param string $curr. Currency name
	 * @return string 
	 */
	
	public function currency($amount, $curr)
	{
		$currencies = array('USD' => '$', 'GBP' => '£', 'EUR' => '€'); // or use Intl Extension NumberFormatter if installed
		return $currencies[$curr] . number_format(round($amount, 2), 2, '.', ',');
	
	}
}
