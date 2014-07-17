<?php

class Base_Controller extends Controller {


    public function __construct()
    {

        // Asset::container('header')->add('bootstrap','//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css');
        // Asset::container('header')->add('jquery','https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js');
        Asset::container('header')->add('script','js/javascript.js');
        // Asset::container('header')->add('jbootstrapjs', '//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js','jquery');

       // Asset::container('header')->add('font-awesome','http://netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css');

        // Asset::container('footer')->add('the-story','css/bootstrap3/the-story.js');
        Asset::container('header')->add('story','css/bootstrap3/the-story.css');
        // Asset::container('header')->add('p-controls','css/bootstrap3/p-controls.css');
        /* HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries */


        /* [if IE 7] */
        Asset::container('header')->add('font-awesome','css/font-awesome-ie7.min.css');
        /*  [endif] */
        /* [if lte IE 8] */
        Asset::container('header')->add('font-awesome','css/ace.min-ie8.css');
       
        /* [endif] */
/* [if lt IE 9] */
        Asset::container('header')->add('bootstrap','js/jqueryIE9.js');
        Asset::container('header')->add('bootstrap','css/bootstrap3/style-ie.css');
        
/* [endif] */



        parent::__construct();
    }

    /**
	 * Catch-all method for requests that can't be matched.
	 *
	 * @param  string    $method
	 * @param  array     $parameters
	 * @return Response
	 */

	public function __call($method, $parameters)
	{
		return Response::error('404');
	}

}