<?php

/**
 * Convert HTML characters to entities.
 *
 * The encoding specified in the application configuration file will be used.
 *
 * @param  string  $value
 * @return string
 */
function e($value)
{
	return HTML::entities($value);
}

/**
 * Retrieve a language line.
 *
 * @param  string  $key
 * @param  array   $replacements
 * @param  string  $language
 * @return string
 */
function __($key, $replacements = array(), $language = null)
{
	return Lang::line($key, $replacements, $language);
}

/**
 * Dump the given value and kill the script.
 *
 * @param  mixed  $value
 * @return void
 */
function dd($value)
{
	echo "<pre>";
	var_dump($value);
	echo "</pre>";
	die;
}

/**
 * Get an item from an array using "dot" notation.
 *
 * <code>
 *		// Get the $array['user']['name'] value from the array
 *		$name = array_get($array, 'user.name');
 *
 *		// Return a default from if the specified item doesn't exist
 *		$name = array_get($array, 'user.name', 'Taylor');
 * </code>
 *
 * @param  array   $array
 * @param  string  $key
 * @param  mixed   $default
 * @return mixed
 */
function array_get($array, $key, $default = null)
{
	if (is_null($key)) return $array;

	// To retrieve the array item using dot syntax, we'll iterate through
	// each segment in the key and look for that value. If it exists, we
	// will return it, otherwise we will set the depth of the array and
	// look for the next segment.
	foreach (explode('.', $key) as $segment)
	{
		if ( ! is_array($array) or ! array_key_exists($segment, $array))
		{
			return value($default);
		}

		$array = $array[$segment];
	}

	return $array;
}

/**
 * Set an array item to a given value using "dot" notation.
 *
 * If no key is given to the method, the entire array will be replaced.
 *
 * <code>
 *		// Set the $array['user']['name'] value on the array
 *		array_set($array, 'user.name', 'Taylor');
 *
 *		// Set the $array['user']['name']['first'] value on the array
 *		array_set($array, 'user.name.first', 'Michael');
 * </code>
 *
 * @param  array   $array
 * @param  string  $key
 * @param  mixed   $value
 * @return void
 */
function array_set(&$array, $key, $value)
{
	if (is_null($key)) return $array = $value;

	$keys = explode('.', $key);

	// This loop allows us to dig down into the array to a dynamic depth by
	// setting the array value for each level that we dig into. Once there
	// is one key left, we can fall out of the loop and set the value as
	// we should be at the proper depth.
	while (count($keys) > 1)
	{
		$key = array_shift($keys);

		// If the key doesn't exist at this depth, we will just create an
		// empty array to hold the next value, allowing us to create the
		// arrays to hold the final value.
		if ( ! isset($array[$key]) or ! is_array($array[$key]))
		{
			$array[$key] = array();
		}

		$array =& $array[$key];
	}

	$array[array_shift($keys)] = $value;
}

/**
 * Remove an array item from a given array using "dot" notation.
 *
 * <code>
 *		// Remove the $array['user']['name'] item from the array
 *		array_forget($array, 'user.name');
 *
 *		// Remove the $array['user']['name']['first'] item from the array
 *		array_forget($array, 'user.name.first');
 * </code>
 *
 * @param  array   $array
 * @param  string  $key
 * @return void
 */
function array_forget(&$array, $key)
{
	$keys = explode('.', $key);

	// This loop functions very similarly to the loop in the "set" method.
	// We will iterate over the keys, setting the array value to the new
	// depth at each iteration. Once there is only one key left, we will
	// be at the proper depth in the array.
	while (count($keys) > 1)
	{
		$key = array_shift($keys);

		// Since this method is supposed to remove a value from the array,
		// if a value higher up in the chain doesn't exist, there is no
		// need to keep digging into the array, since it is impossible
		// for the final value to even exist.
		if ( ! isset($array[$key]) or ! is_array($array[$key]))
		{
			return;
		}

		$array =& $array[$key];
	}

	unset($array[array_shift($keys)]);
}

/**
 * Return the first element in an array which passes a given truth test.
 *
 * <code>
 *		// Return the first array element that equals "Taylor"
 *		$value = array_first($array, function($k, $v) {return $v == 'Taylor';});
 *
 *		// Return a default value if no matching element is found
 *		$value = array_first($array, function($k, $v) {return $v == 'Taylor'}, 'Default');
 * </code>
 *
 * @param  array    $array
 * @param  Closure  $callback
 * @param  mixed    $default
 * @return mixed
 */
function array_first($array, $callback, $default = null)
{
	foreach ($array as $key => $value)
	{
		if (call_user_func($callback, $key, $value)) return $value;
	}

	return value($default);
}

/**
 * Recursively remove slashes from array keys and values.
 *
 * @param  array  $array
 * @return array
 */
function array_strip_slashes($array)
{
	$result = array();

	foreach($array as $key => $value)
	{
		$key = stripslashes($key);

		// If the value is an array, we will just recurse back into the
		// function to keep stripping the slashes out of the array,
		// otherwise we will set the stripped value.
		if (is_array($value))
		{
			$result[$key] = array_strip_slashes($value);
		}
		else
		{
			$result[$key] = stripslashes($value);
		}
	}

	return $result;
}


/**
 * Divide an array into two arrays. One with keys and the other with values.
 *
 * @param  array  $array
 * @return array
 */
function array_divide($array)
{
	return array(array_keys($array), array_values($array));
}

/**
 * Pluck an array of values from an array.
 *
 * @param  array   $array
 * @param  string  $key
 * @return array
 */
function array_pluck($array, $key)
{
	return array_map(function($v) use ($key)
	{
		return is_object($v) ? $v->$key : $v[$key];

	}, $array);
}

/**
 * Get a subset of the items from the given array.
 *
 * @param  array  $array
 * @param  array  $keys
 * @return array
 */
function array_only($array, $keys)
{
	return array_intersect_key( $array, array_flip((array) $keys) );
}

/**
 * Get all of the given array except for a specified array of items.
 *
 * @param  array  $array
 * @param  array  $keys
 * @return array
 */
function array_except($array, $keys)
{
	return array_diff_key( $array, array_flip((array) $keys) );
}

/**
 * Transform Eloquent models to a JSON object.
 *
 * @param  Eloquent|array  $models
 * @return object
 */
function eloquent_to_json($models)
{
	if ($models instanceof Laravel\Database\Eloquent\Model)
	{
		return json_encode($models->to_array());
	}

	return json_encode(array_map(function($m) { return $m->to_array(); }, $models));
}

/**
 * Determine if "Magic Quotes" are enabled on the server.
 *
 * @return bool
 */
function magic_quotes()
{
	return function_exists('get_magic_quotes_gpc') and get_magic_quotes_gpc();
}

/**
 * Return the first element of an array.
 *
 * This is simply a convenient wrapper around the "reset" method.
 *
 * @param  array  $array
 * @return mixed
 */
function head($array)
{
	return reset($array);
}

/**
 * Generate an application URL.
 *
 * <code>
 *		// Create a URL to a location within the application
 *		$url = url('user/profile');
 *
 *		// Create a HTTPS URL to a location within the application
 *		$url = url('user/profile', true);
 * </code>
 *
 * @param  string  $url
 * @param  bool    $https
 * @return string
 */
function url($url = '', $https = null)
{
	return URL::to($url, $https);
}

/**
 * Generate an application URL to an asset.
 *
 * @param  string  $url
 * @param  bool    $https
 * @return string
 */
function asset($url, $https = null)
{
	return URL::to_asset($url, $https);
}

/**
 * Generate a URL to a controller action.
 *
 * <code>
 *		// Generate a URL to the "index" method of the "user" controller
 *		$url = action('user@index');
 *
 *		// Generate a URL to http://example.com/user/profile/taylor
 *		$url = action('user@profile', array('taylor'));
 * </code>
 *
 * @param  string  $action
 * @param  array   $parameters
 * @return string
 */
function action($action, $parameters = array())
{
	return URL::to_action($action, $parameters);
}

/**
 * Generate a URL from a route name.
 *
 * <code>
 *		// Create a URL to the "profile" named route
 *		$url = route('profile');
 *
 *		// Create a URL to the "profile" named route with wildcard parameters
 *		$url = route('profile', array($username));
 * </code>
 *
 * @param  string  $name
 * @param  array   $parameters
 * @return string
 */
function route($name, $parameters = array())
{
	return URL::to_route($name, $parameters);
}

/**
 * Determine if a given string begins with a given value.
 *
 * @param  string  $haystack
 * @param  string  $needle
 * @return bool
 */
function starts_with($haystack, $needle)
{
	return strpos($haystack, $needle) === 0;
}

/**
 * Determine if a given string ends with a given value.
 *
 * @param  string  $haystack
 * @param  string  $needle
 * @return bool
 */
function ends_with($haystack, $needle)
{
	return $needle == substr($haystack, strlen($haystack) - strlen($needle));
}

/**
 * Determine if a given string contains a given sub-string.
 *
 * @param  string        $haystack
 * @param  string|array  $needle
 * @return bool
 */
function str_contains($haystack, $needle)
{
	foreach ((array) $needle as $n)
	{
		if (strpos($haystack, $n) !== false) return true;
	}

	return false;
}

/**
 * Cap a string with a single instance of the given string.
 *
 * @param  string  $value
 * @param  string  $cap
 * @return string
 */
function str_finish($value, $cap)
{
	return rtrim($value, $cap).$cap;
}

/**
 * Determine if the given object has a toString method.
 *
 * @param  object  $value
 * @return bool
 */
function str_object($value)
{
	return is_object($value) and method_exists($value, '__toString');
}

/**
 * Get the root namespace of a given class.
 *
 * @param  string  $class
 * @param  string  $separator
 * @return string
 */
function root_namespace($class, $separator = '\\')
{
	if (str_contains($class, $separator))
	{
		return head(explode($separator, $class));
	}
}

/**
 * Get the "class basename" of a class or object.
 *
 * The basename is considered to be the name of the class minus all namespaces.
 *
 * @param  object|string  $class
 * @return string
 */
function class_basename($class)
{
	if (is_object($class)) $class = get_class($class);

	return basename(str_replace('\\', '/', $class));
}

/**
 * Return the value of the given item.
 *
 * If the given item is a Closure the result of the Closure will be returned.
 *
 * @param  mixed  $value
 * @return mixed
 */
function value($value)
{
	return (is_callable($value) and ! is_string($value)) ? call_user_func($value) : $value;
}

/**
 * Short-cut for constructor method chaining.
 *
 * @param  mixed  $object
 * @return mixed
 */
function with($object)
{
	return $object;
}

/**
 * Determine if the current version of PHP is at least the supplied version.
 *
 * @param  string  $version
 * @return bool
 */
function has_php($version)
{
	return version_compare(PHP_VERSION, $version) >= 0;
}

/**
 * Get a view instance.
 *
 * @param  string  $view
 * @param  array   $data
 * @return View
 */
function view($view, $data = array())
{
	if (is_null($view)) return '';

	return View::make($view, $data);
}

/**
 * Render the given view.
 *
 * @param  string  $view
 * @param  array   $data
 * @return string
 */
function render($view, $data = array())
{
	if (is_null($view)) return '';

	return View::make($view, $data)->render();
}

/**
 * Get the rendered contents of a partial from a loop.
 *
 * @param  string  $partial
 * @param  array   $data
 * @param  string  $iterator
 * @param  string  $empty
 * @return string
 */
function render_each($partial, array $data, $iterator, $empty = 'raw|')
{
	return View::render_each($partial, $data, $iterator, $empty);
}

/**
 * Get the string contents of a section.
 *
 * @param  string  $section
 * @return string
 */
function yield($section)
{
	return Section::yield($section);
}

/**
 * Get a CLI option from the argv $_SERVER variable.
 *
 * @param  string  $option
 * @param  mixed   $default
 * @return string
 */
function get_cli_option($option, $default = null)
{
	foreach (Laravel\Request::foundation()->server->get('argv') as $argument)
	{
		if (starts_with($argument, "--{$option}="))
		{
			return substr($argument, strlen($option) + 3);
		}
	}

	return value($default);
}
	
/**
 * Calculate the human-readable file size (with proper units).
 *
 * @param  int     $size
 * @return string
 */
function get_file_size($size)
{
	$units = array('Bytes', 'KiB', 'MiB', 'GiB', 'TiB', 'PiB', 'EiB');
	return @round($size / pow(1024, ($i = floor(log($size, 1024)))), 2).' '.$units[$i];
}

/**
 * Convert stdObject to associative array
 *
 * @param $data
 * @return array
 */
function object_to_array($data)
{
    if (is_array($data) || is_object($data))
    {
        $result = array();
        foreach ($data as $key => $value)
        {
            $result[$key] = object_to_array($value);
        }
        return $result;
    }
    return $data;
}

/**
 * @param $array
 * @return array
 * example: array([0]=>Class Object array())
 */
function multi_object_to_multi_array($array)
{
    $result=array();
    if(is_array($array))
    {
        foreach($array as $array1)
        {
            array_push($result,(array)$array1);

        }
    }
    if(is_object($array))
    {
        array_push($result,(array)$array);
    }
    return $result;
}

/**
 * @param $search
 * @param $arr
 * @param $key_of_search
 * @param $name_of_key_to_return_value
 * @return bool
 */
function get_value_from_array($search,$arr,$key_of_search,$name_of_key_to_return_value)
{
    if(is_array($arr))
    {

        foreach($arr as $values)
        {

            if($values[$key_of_search] == $search)
            {
            return $values[$name_of_key_to_return_value];
            }
        }
    }
    return false;
}
/**
 * @param $search
 * @param $arr//Object array
 * @param $key_of_search
 * @param $name_of_key_to_return_value
 * @return bool
 */
function get_value_from_object_array($search,$arr,$key_of_search,$name_of_key_to_return_value)
{
    if(is_object($arr))
    {
        if($arr->$key_of_search == $search)
        {
            return $arr->$name_of_key_to_return_value;
        }
    }
    if(is_array($arr))
    {
        if(isset($arr[$key_of_search]))
        {
            if($arr[$key_of_search] == $search)
            {
                return $arr[$name_of_key_to_return_value];
            }
        }
    }
    return false;
}
/**
 * @param $search
 * @param $arr
 * @param $key_of_search
 * @param $name_of_key_to_return_value
 * @return bool
 */
function get_value_from_multi_object_array($search,$arr,$key_of_search,$name_of_key_to_return_value)
{
    if(is_array($arr))
    {
        foreach($arr as $array)
        {
            if($array->$key_of_search == $search)
            {
                return $array->$name_of_key_to_return_value;
            }
        }
    }
    elseif(is_object($arr))
    {
        foreach($arr as $array)
        {
            if($array->$key_of_search == $search)
            {
                return $array->$name_of_key_to_return_value;
            }
        }
    }
    else
    {
        return false;
    }
}
function get_value_with_2compare_from_multi_object_array($search,$search2,$arr,$key_of_search,$key_of_search2,$name_of_key_to_return_value)
{
    if(is_array($arr))
    {
        foreach($arr as $array)
        {
            if($array->$key_of_search == $search && $array->$key_of_search2 == $search2)
            {
                return $array->$name_of_key_to_return_value;
            }
        }
    }
    elseif(is_object($arr))
    {
        foreach($arr as $array)
        {
            if($array->$key_of_search == $search && $array->$key_of_search2 == $search2 )
            {
                return $array->$name_of_key_to_return_value;
            }
        }
    }
    else
    {
        return false;
    }
}
/**
 * @param $comma_separated_string
 * @param $arr
 * @param $key_of_search
 * @param $name_of_key_to_return_value
 * @return string
 */
function get_multi_value_from_object_array($comma_separated_string,$arr,$key_of_search,$name_of_key_to_return_value)
{
    $search=explode(',',$comma_separated_string);
    $value='';
    foreach($search as $search_value)
    {
        foreach($arr as $arry)
        {
             if($arry->$key_of_search == $search_value)
                {
                    $value.=$arry->$name_of_key_to_return_value.',';
                }
         }
    }
    $res=substr($value,0,-1);
    return $res;

}
function xml_to_array($xml,$main_heading = '') {
    $deXml = simplexml_load_string($xml);
    $deJson = json_encode($deXml);
    $xml_array = json_decode($deJson,TRUE);
    if (! empty($main_heading)) {
        $returned = $xml_array[$main_heading];
        return $returned;
    } else {
        return $xml_array;
    }
}
/**
 * Select which array contains same id in another array
 * @param $obj_arr
 * @param $search_array
 * @param $key_of_search
 * @return array
 */function get_array_by_objectId_from_object_array($obj_arr,$search_array,$key_of_search)
{
    $result=array();
    $ids='';
     if(is_array($obj_arr))
    {
            foreach($search_array as $search_array1)
            {
                foreach($obj_arr as $obj_arr1)
                {
                    if($search_array1->$key_of_search == $obj_arr1->$key_of_search)
                    {
                    $ids.=$obj_arr1->$key_of_search.",";
                        echo "<pre>";
        //                unset($obj_arr1->appointment_id);
                        array_push($result,(array)$obj_arr1);
                    }
                }
            }
    }
    elseif(is_object($obj_arr))
    {
        foreach($search_array as $search_array1)
        {
           if($obj_arr->$key_of_search==$search_array1->$key_of_search)
           {
               $ids.=$obj_arr->$key_of_search.',';
               array_push($result,(array)$obj_arr);
           }
        }
    }
    array_push($result,array($key_of_search=>substr($ids,0,-1)));

    return $result;
}
function get_array_by_idString_from_object_array($obj_arr,$ids_string,$key_of_search)
{
    $result=array();
    $ids=explode(',',$ids_string);
    if(is_array($obj_arr))
    {
        foreach($ids as $id)
        {
            foreach($obj_arr as $obj_arr1)
            {

                if($id == $obj_arr1->$key_of_search)
                {
                    array_push($result,(array)$obj_arr1);
                }
            }
        }
    }
    elseif(is_object($obj_arr))
    {
        foreach($ids as $id)
        {
            if($obj_arr->$key_of_search == $id)
            {
                array_push($result,(array)$obj_arr);
            }
        }
    }
    return $result;
}
function multi_array_diff($array1,$array2)
{
    $result=array();
    for($i=0;$i<=count($array1)-1;$i++)
    {
        $res=array_diff_assoc($array1[$i],$array2[$i]);
        array_push($result,$res);
    }
    return $result;
}
/**
 * @param $arr
 * @param $key
 * @param $KeyReturn
 * @return string
 */function multi_value_from_object_array($arr,$key)
{
    $string="";
    foreach($arr as $arr1)
    {
        $string.=$arr1->$key.',';
    }
    $res=substr($string,0,-1);
    return $res;
}
function translation_array()
{

  $arr=Array
  (
      'case_id' => 'CASE NO',
      'client_id' => 'CLIENT',
      'client_name'=>'CLIENT NAME',
      'state'=>'STATE',
      'lawyer_id' => 'LAWYER',
      'case_name' => 'CASE NAME',
      'case_no' => 'CASE NO',
      'case_type' => 'CASE TYPE',
      'case_subject' => 'CASE SUBJECT',
      'party_type' => 'PARTY TYPE',
      'opp_party_name' => 'OPPOSITE CLIENT NAME',
      'opp_party_type' => 'OPPOSITE PARTY TYPE',
      'opp_advocate' => 'OPPOSITE ADVOCATE',
      'brief_given_by' => 'BRIEF GIVEN BY',
      'court_name' => 'COURT NAME',
      'claim' => 'CLAIM',
      'citation_referred' => 'CITATION REFERRED',
      'case_description' => 'CASE DESCRIPTION',
      'case_color' => 'CASE COLOR',
      'associate_lawyer' => 'ASSOCIATE LAWYER',
      'status' => 'STATUS',
      'updated_by' => 'UPDATED BY',
      'date_of_filling' => 'DATE OF FILED',
      'created_on' => 'CREATED ON',
      'hearing_id' => 'HEARING ID',
      'doc_no' => 'DOC NAME',
      'description' => 'DESCRIPTION',
      'court_hall' => 'COURT HALL',
      'judge' => 'JUDGE',
      'stage' => 'STAGE',
      'hearing_date' => 'HEARING DATE',
      'next_hearing_date' => 'NEXT HEARING DATE',
      'action_plan' => 'ACTION PLAN',
      'created_date' => 'CREATED DATE',
      'first_name' => 'FIRST NAME',
      'last_name' => 'LAST NAME',
      'user_email' => 'EMAIL',
      'email'=>'EMAIL',
      'user_role' => 'USER ROLE',
      'user_log' => 'USER LOG',
      'lawyer_subject' => 'LAWYER SUBJECT',
      'mobile' => 'MOBILE',
      'phone' => 'PHONE',
      'address' => 'ADDRESS',
      'city' => 'CITY',
      'pincode' => 'PINCODE',
      'reg_date' => 'REG DATE',
      'exp_date' => 'EXP DATE',
      'payment' => 'PAYMENT',
      'sms_deliver'=>'SmS Deliver',
      'docket_no'=>'DOCKET NO',
      'case_link'=>'CASE NO',
      'event_name'=>'EVENT NAME',
      'contact_person'=>'CONTACT PERSON',
      'location'=>'LOCATION',
      'username'=>'USERNAME',
      'company'=>'COMPANY',
      'from_date'=>'DATE',
      'to_date'=>'To Date',
      'lawyers'=>'ASSOCIATE(S)',
      'last_hearing_id'=>'Last Hearing ID',
      'old_id'=>'OLD ID',
      'crime_no'=>'CRIME NO',
      'updated_at'=>'UPDATED AT'


  );
    return $arr;
}
/**
 * @param $arr
 * @param $string
 * @return mixed
 * multiple unset in given array
 */
function array_unset($arr,$string)
{
    $string1=explode(',',$string);
    if(is_array($arr))
    {
        foreach($string1 as $value)
        {
            if($value !='')
            {
                unset($arr[$value]);
            }
        }
    }
    elseif(is_object($arr))
    {
        foreach($string1 as $value)
        {
            if($value!='')
            {
                unset($arr->$value);
            }
        }
    }
    return $arr;
}

    /**
     * @param $array
     * @param $index
     * @param $value
     * @return mixed
     */
function filter_by_value ($array, $index, $value){
        if(is_array($array) && count($array)>0)
        {
            foreach(array_keys($array) as $key){
                $temp[$key] = $array[$key][$index];

                if ($temp[$key] == $value){
                    $newarray[$key] = $array[$key];
                }
            }
        }
        return $newarray;
    }
function filter_by_key_compare($arr2,$arr1,$key)
{
    echo"<pre>";
    print_r($arr1);
    print_r($arr2);
    $select_arr1=array();
    if(is_array($arr1) && is_array($arr2))
    {
        foreach($arr1 as $arr1_1)
        {
           $arr1_2=is_object($arr1_1) ? (array)$arr1_1 : $arr1_1;
           if(array_key_exists('client_id',$arr1_1))
           {
               foreach($arr2 as $arr2_1)
               {
                   $arr2_2=is_object($arr2_1) ? (array)$arr2_1 : $arr2_1;
                   if(array_key_exists('client_id',$arr2_2))
                   {
                       if($arr2_2['client_id']==$arr1_2['client_id'])
                       {
                           echo "s,";
                       }
                   }
               }
           }

        }
    }
}
    function is_str_contain($string, $keyword){
        if(empty($string) || empty($keyword))
            return false;
        $keyword_first_char = $keyword[0];
        $keyword_length = strlen($keyword);
        $string_length = strlen($string);

        if( $string_length < $keyword_length )
            return false;

        if( $string_length == $keyword_length ){
            if($string == $keyword)
                return true;
            else
                return false;
        }

        if ($keyword_length > 1){
            for( $i=0; $i < $string_length; $i++){
                //Check if keyword's first char == string's first char
                if ($keyword_first_char == $string[$i] ){
                    $match = 1;
                    for($j = 1; $j < $keyword_length; $j++){
                        if( ($i+$j < $string_length) && $keyword[$j] == $string[$i+$j] ){
                            $match++;
                        }
                    }
                    if($match == $keyword_length){
                        return true;
                    }
                }
            }
        }

        if($keyword_length == 1){
            for( $i=0; $i < $string_length; $i++){
                //Check if keyword's first char == string's first char
                if ($keyword_first_char == $string[$i] ){
                    return true;
                }
            }
        }
        return false;
    }
function array_column($input = null, $columnKey = null, $indexKey = null)
{
    // Using func_get_args() in order to check for proper number of
    // parameters and trigger errors exactly as the built-in array_column()
    // does in PHP 5.5.
    $argc = func_num_args();
    $params = func_get_args();

    if ($argc < 2) {
        trigger_error("array_column() expects at least 2 parameters, {$argc} given", E_USER_WARNING);
        return null;
    }

    if (!is_array($params[0])) {
        trigger_error('array_column() expects parameter 1 to be array, ' . gettype($params[0]) . ' given', E_USER_WARNING);
        return null;
    }

    if (!is_int($params[1])
        && !is_float($params[1])
        && !is_string($params[1])
        && $params[1] !== null
        && !(is_object($params[1]) && method_exists($params[1], '__toString'))
    ) {
        trigger_error('array_column(): The column key should be either a string or an integer', E_USER_WARNING);
        return false;
    }

    if (isset($params[2])
        && !is_int($params[2])
        && !is_float($params[2])
        && !is_string($params[2])
        && !(is_object($params[2]) && method_exists($params[2], '__toString'))
    ) {
        trigger_error('array_column(): The index key should be either a string or an integer', E_USER_WARNING);
        return false;
    }

    $paramsInput = $params[0];
    $paramsColumnKey = ($params[1] !== null) ? (string) $params[1] : null;

    $paramsIndexKey = null;
    if (isset($params[2])) {
        if (is_float($params[2]) || is_int($params[2])) {
            $paramsIndexKey = (int) $params[2];
        } else {
            $paramsIndexKey = (string) $params[2];
        }
    }

    $resultArray = array();

    foreach ($paramsInput as $row) {

        $key = $value = null;
        $keySet = $valueSet = false;

        if ($paramsIndexKey !== null && array_key_exists($paramsIndexKey, $row)) {
            $keySet = true;
            $key = (string) $row[$paramsIndexKey];
        }

        if ($paramsColumnKey === null) {
            $valueSet = true;
            $value = $row;
        } elseif (is_array($row) && array_key_exists($paramsColumnKey, $row)) {
            $valueSet = true;
            $value = $row[$paramsColumnKey];
        }

        if ($valueSet) {
            if ($keySet) {
                $resultArray[$key] = $value;
            } else {
                $resultArray[] = $value;
            }
        }

    }

    return $resultArray;
}
function roundsize($size){
    $i=0;
    $iec = array("B", "Kb", "Mb", "Gb", "Tb");
    while (($size/1024)>1) {
        $size=$size/1024;
        $i++;}
    return(round($size,1)." ".$iec[$i]);}


    function no_to_words($no)
	{
		$words = array('0'=> '' ,'1'=> 'one' ,'2'=> 'two' ,'3' => 'three','4' => 'four','5' => 'five','6' => 'six','7' => 'seven','8' => 'eight','9' => 'nine','10' => 'ten','11' => 'eleven','12' => 'twelve','13' => 'thirteen','14' => 'fouteen','15' => 'fifteen','16' => 'sixteen','17' => 'seventeen','18' => 'eighteen','19' => 'nineteen','20' => 'twenty','30' => 'thirty','40' => 'fourty','50' => 'fifty','60' => 'sixty','70' => 'seventy','80' => 'eighty','90' => 'ninty','100' => 'hundred &','1000' => 'thousand','100000' => 'lakh','10000000' => 'crore');
		if($no == 0 || $no < 0)
			return ' ';
		else {
			$novalue='';
			$highno=$no;
			$remainno=0;
			$value=100;
			$value1=1000;
			while($no>=100) 
			{
				if(($value <= $no) &&($no < $value1)) 
				{
					$novalue=$words["$value"];
					$highno = (int)($no/$value);
					$remainno = $no % $value;
					break;
				}
				$value= $value1;
				$value1 = $value * 100;
			}
		if(array_key_exists("$highno",$words))
		return rtrim($words["$highno"]." ".$novalue." ".no_to_words($remainno),"& ");
		else {
		$unit=$highno%10;
		$ten =(int)($highno/10)*10;
		return rtrim($words["$ten"]." ".$words["$unit"]." ".$novalue." ".no_to_words($remainno),"& ");
		}
		}
	}	
	if ( !function_exists('mysql_escape'))
	{
	    function mysql_escape($inp)
	    { 
	        if(is_array($inp)) return array_map(__METHOD__, $inp);

	        if(!empty($inp) && is_string($inp)) { 
	            return str_replace(array('\\', "\0", "\n", "\r", "'", '"', "\x1a"), array('\\\\', '\\0', '\\n', '\\r', "\\'", '\\"', '\\Z'), $inp); 
	        } 

	        return $inp; 
	    }
	}