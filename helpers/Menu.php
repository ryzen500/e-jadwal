<?php
/**
 * Menu Items
 * All Project Menu
 * @category  Menu List
 */

class Menu{
	
	
			public static $navbarsideleft = array(
		array(
			'path' => 'home', 
			'label' => 'Home', 
			'icon' => '<i class="fa fa-home fa-2x"></i>'
		),
		
		array(
			'path' => 'guru', 
			'label' => 'Master Data', 
			'icon' => '','submenu' => array(
		array(
			'path' => 'hari', 
			'label' => 'Hari', 
			'icon' => '<i class="fa fa-calendar fa-2x"></i>'
		),
		
		array(
			'path' => 'kelas', 
			'label' => 'Kelas', 
			'icon' => '<i class="fa fa-tasks fa-2x"></i>'
		),
		
		array(
			'path' => 'guru', 
			'label' => 'Guru', 
			'icon' => '<i class="fa fa-users fa-2x"></i>'
		),
		
		array(
			'path' => 'mapel', 
			'label' => 'Mata Pelajaran', 
			'icon' => '<i class="fa fa-tasks fa-2x"></i>'
		),
		
		array(
			'path' => 'tahun_ajaran', 
			'label' => 'Tahun Ajaran', 
			'icon' => '<i class="fa fa-calendar-check-o fa-2x"></i>'
		),
		
		array(
			'path' => 'roles', 
			'label' => 'User Roles', 
			'icon' => '','submenu' => array(
		array(
			'path' => 'role_permissions', 
			'label' => 'Role Permissions', 
			'icon' => ''
		),
		
		array(
			'path' => 'roles', 
			'label' => 'Roles', 
			'icon' => ''
		)
	)
		)
	)
		),
		
		array(
			'path' => 'jadwal', 
			'label' => 'Jadwal', 
			'icon' => '<i class="fa fa-calendar-check-o fa-2x"></i>'
		)
	);
		
	
	
			public static $jk = array(
		array(
			"value" => "L", 
			"label" => "Laki-laki", 
		),
		array(
			"value" => "p", 
			"label" => "Perempuan", 
		),);
		
}