<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Config
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/View/Pages/home.ctp)...
 */
	Router::connect('/', array('controller' => 'Users', 'action' => 'index', 'Users'));
	Router::connect('/users/logout', array('controller' => 'Users', 'action' => 'logout', 'Users'));
	Router::connect('/users/list', array('controller' => 'Users', 'action' => 'userlist', 'Users'));
	Router::connect('/users/add', array('controller' => 'Users', 'action' => 'add', 'Users'));
	Router::connect('/users/edit', array('controller' => 'Users', 'action' => 'edit', 'Users'));
	Router::connect('/users/check_exist', array('controller' => 'Users', 'action' => 'check_exist', 'Users'));
	Router::connect('/users/userinfo', array('controller' => 'Users', 'action' => 'userinfo', 'Users'));

	Router::connect('/status', array('controller' => 'Status', 'action' => 'index', 'Status'));

	Router::connect('/categories', array('controller' => 'Categories', 'action' => 'index', 'Categories'));
	Router::connect('/categories/add', array('controller' => 'Categories', 'action' => 'add', 'Categories'));
	Router::connect('/categories/edit', array('controller' => 'Categories', 'action' => 'edit', 'Categories'));
	Router::connect('/categories/delete', array('controller' => 'Categories', 'action' => 'delete', 'Categories'));
	Router::connect('/categories/check_exist', array('controller' => 'Categories', 'action' => 'check_exist', 'Categories'));

	Router::connect('/companies', array('controller' => 'Companies', 'action' => 'index', 'Companies'));
	Router::connect('/companies/add', array('controller' => 'Companies', 'action' => 'add', 'Companies'));
	Router::connect('/companies/edit', array('controller' => 'Companies', 'action' => 'edit', 'Companies'));
	Router::connect('/companies/delete', array('controller' => 'Companies', 'action' => 'delete', 'Companies'));
	Router::connect('/companies/check_exist', array('controller' => 'Companies', 'action' => 'check_exist', 'Companies'));

	Router::connect('/projects', array('controller' => 'Projects', 'action' => 'index', 'Projects'));
	Router::connect('/projects/add', array('controller' => 'Projects', 'action' => 'add', 'Projects'));
	Router::connect('/projects/edit', array('controller' => 'Projects', 'action' => 'edit', 'Projects'));
	Router::connect('/projects/delete', array('controller' => 'Projects', 'action' => 'delete', 'Projects'));
	Router::connect('/projects/check_exist', array('controller' => 'Projects', 'action' => 'check_exist', 'Projects'));

	Router::connect('/templates', array('controller' => 'Templates', 'action' => 'index', 'Templates'));

    Router::connect('/roles', array('controller' => 'Roles', 'action' => 'index', 'Roles'));
    Router::connect('/roles/add', array('controller' => 'Roles', 'action' => 'add', 'Roles'));
    Router::connect('/roles/edit', array('controller' => 'Roles', 'action' => 'edit', 'Roles'));
    Router::connect('/roles/delete', array('controller' => 'Roles', 'action' => 'delete', 'Roles'));
    Router::connect('/roles/check_exist', array('controller' => 'Roles', 'action' => 'check_exist', 'Roles'));

    Router::connect('/details', array('controller' => 'Details', 'action' => 'index', 'Details'));
    Router::connect('/details/add', array('controller' => 'Details', 'action' => 'add', 'Details'));
    Router::connect('/details/edit', array('controller' => 'Details', 'action' => 'edit', 'Details'));
    Router::connect('/details/delete', array('controller' => 'Details', 'action' => 'delete', 'Details'));
    Router::connect('/details/check_exist', array('controller' => 'Details', 'action' => 'check_exist', 'Details'));

    Router::connect('/baojias', array('controller' => 'Baojias', 'action' => 'index', 'Baojias'));
    Router::connect('/baojias/add', array('controller' => 'Baojias', 'action' => 'add', 'Baojias'));
    Router::connect('/baojias/edit', array('controller' => 'Baojias', 'action' => 'edit', 'Baojias'));
    Router::connect('/baojias/delete', array('controller' => 'Baojias', 'action' => 'delete', 'Baojias'));
    Router::connect('/baojias/check_exist', array('controller' => 'Baojias', 'action' => 'check_exist', 'Baojias'));
    Router::connect('/baojias/check', array('controller' => 'Baojias', 'action' => 'check', 'Baojias'));
    Router::connect('/baojias/home', array('controller' => 'Baojias', 'action' => 'home', 'Baojias'));
    Router::connect('/baojias/add_detail', array('controller' => 'Baojias', 'action' => 'add_detail', 'Baojias'));
    Router::connect('/baojias/delete_detail', array('controller' => 'Baojias', 'action' => 'delete_detail', 'Baojias'));
    Router::connect('/baojias/load_table', array('controller' => 'Baojias', 'action' => 'load_table', 'Baojias'));
    Router::connect('/baojias/get_details', array('controller' => 'Baojias', 'action' => 'get_details', 'Baojias'));

    Router::connect('/systems', array('controller' => 'Systems', 'action' => 'index', 'Systems'));
/**
 * ...and connect the rest of 'Pages' controller's URLs.
 */
	//Router::connect('/pages/*', array('controller' => 'pages', 'action' => 'display'));

/**
 * Load all plugin routes. See the CakePlugin documentation on
 * how to customize the loading of plugin routes.
 */
	CakePlugin::routes();

/**
 * Load the CakePHP default routes. Only remove this if you do not want to use
 * the built-in default routes.
 */
	require CAKE . 'Config' . DS . 'routes.php';
