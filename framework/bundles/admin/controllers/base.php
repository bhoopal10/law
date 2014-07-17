<?php

class Admin_Base_Controller extends Controller {


    /**
	 * Catch-all method for requests that can't be matched.
	 *
	 * @param  string    $method
	 * @param  array     $parameters
	 * @return Response
	 */
    public function __construct()
    {

        Asset::container('header')->bundle('admin');
        Asset::container('header')->add('bootstrap','css/styles.css');
        Asset::container('header')->add('font-awesome','http://netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css');
        Asset::container('header')->add('jquerys', 'js/javascript1.js');
         Asset::container('footer')->bundle('admin');
 

        parent::__construct();
    }
	public function __call($method, $parameters)
	{
		return Response::error('404');
	}


}