<?php
Autoloader::namespaces(array(
    'Admin\\Libraries' 	 => Bundle::path('admin') . 'libraries',
    'Admin\\Models'    	 => Bundle::path('admin') . 'models',
    'Admin'            	 => Bundle::path('admin') . 'core',

));
Autoloader::alias('Admin\\Admin', 'Admin');

Autoloader::map(array(
    'Role' => Bundle::path('admin').'libraries/role.php'
));
?>