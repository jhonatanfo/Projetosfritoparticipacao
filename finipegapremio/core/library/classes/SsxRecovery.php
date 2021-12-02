<?php
/**
 * 
 * @author Jasiel Macedo <jasielmacedo@gmail.com>
 * @version 1.0
 *
 */

class SsxRecovery extends SsxModels
{
	public $tables = array(
		'ssx_users',
		'ssx_user_token',
		'ssx_groups',
		'ssx_user_groups',
		'ssx_config',
		'ssx_acl_group',
		'ssx_pages',
		'ssx_plugins'
	);
	
	public function __construct($link)
	{
		parent::checkLink($link);
		//$this->checkTables();
	}
	
	public function checkTables()
	{
		if(constant('SSX_DB_TYPE') == "sqlite")
			return;
		
		$onTables = $this->link->get("SHOW TABLES");		
		
		$notFound = array();
		
		if($onTables)
		{
			foreach($onTables as $row)
			{
				foreach($row as $tables)
				{
					if(array_search($tables, $this->tables) === false)
					{
						$notFound[] = $tables;
					}
				}
			}
		}
		
		if($notFound)
		{
			$sql = "";
			foreach($notFound as $row)
			{
				
			}
		}
	}
	
	public $tables_script = array(
		'ssx_users'=>"CREATE TABLE IF NOT EXISTS `ssx_user`
			(
				id CHAR(36) NOT NULL UNIQUE,
				created_by CHAR(36) NOT NULL,
				date_created DATETIME NOT NULL,
				modified_by CHAR(36) NOT NULL,
				date_modified DATETIME NOT NULL,
				deleted TINYINT(1) NOT NULL DEFAULT '0',
				name VARCHAR(255) NOT NULL,
				user VARCHAR(20) NOT NULL,
				email VARCHAR(200) NOT NULL,
				password CHAR(36) NOT NULL,
				status TINYINT(1) DEFAULT '1',
				PRIMARY KEY(id),
				FOREIGN KEY (created_by) REFERENCES ssx_user(id),
				FOREIGN KEY (modified_by) REFERENCES ssx_user(id)
			)ENGINE=innoDB;",
		'ssx_user_token'=>"CREATE TABLE IF NOT EXISTS `ssx_user_token`
			(
				id CHAR(36) NOT NULL UNIQUE,
				created_by CHAR(36) NOT NULL,
				date_created DATETIME NOT NULL,
				modified_by CHAR(36) NOT NULL,
				date_modified DATETIME NOT NULL,
				user_id CHAR(36) NOT NULL,
				token CHAR(36) NOT NULL,
				used TINYINT(1) DEFAULT '0',
				PRIMARY KEY(id),
				FOREIGN KEY (user_id) REFERENCES ssx_user(id)
			)ENGINE=innoDB;",
		'ssx_groups'=>"CREATE TABLE IF NOT EXISTS `ssx_groups`
			(
				id CHAR(36) NOT NULL UNIQUE,
				created_by CHAR(36) NOT NULL,
				date_created DATETIME NOT NULL,
				modified_by CHAR(36) NOT NULL,
				date_modified DATETIME NOT NULL,
				deleted TINYINT(1) NOT NULL DEFAULT '0',
				name VARCHAR(255) NOT NULL,
				description TEXT NULL,
				`level` INT NOT NULL DEFAULT '1',
				status TINYINT(1) DEFAULT '1',
				PRIMARY KEY(id),
				FOREIGN KEY (created_by) REFERENCES ssx_user(id),
				FOREIGN KEY (modified_by) REFERENCES ssx_user(id)
			)ENGINE=innoDB;",
		'ssx_user_groups'=>"CREATE TABLE IF NOT EXISTS `ssx_user_groups`
			(
				user_id CHAR(36) NOT NULL,
				group_id CHAR(36) NOT NULL,
				created_by CHAR(36) NOT NULL,
				date_created DATETIME NOT NULL,
				modified_by CHAR(36) NOT NULL,
				date_modified DATETIME NOT NULL,
				PRIMARY KEY(user_id,group_id),
				FOREIGN KEY (created_by) REFERENCES ssx_user(id),
				FOREIGN KEY (modified_by) REFERENCES ssx_user(id),
				FOREIGN KEY (user_id) REFERENCES ssx_user(id),
				FOREIGN KEY (group_id) REFERENCES ssx_groups(id)
			)ENGINE=innoDB;",
		'ssx_acl_group'=>"CREATE TABLE IF NOT EXISTS `ssx_acl_group`
			(
				id CHAR(36) NOT NULL UNIQUE,
				created_by CHAR(36) NOT NULL,
				date_created DATETIME NOT NULL,
				modified_by CHAR(36) NOT NULL,
				date_modified DATETIME NOT NULL,
				group_id CHAR(36) NOT NULL,
				permissions LONGTEXT NOT NULL,
				PRIMARY KEY(id),
				FOREIGN KEY (created_by) REFERENCES ssx_user(id),
				FOREIGN KEY (modified_by) REFERENCES ssx_user(id),
				FOREIGN KEY (group_id) REFERENCES ssx_groups(id)
			)ENGINE=innoDB;",
		'ssx_plugins'=>"CREATE TABLE IF NOT EXISTS `ssx_plugins`
			(
				id CHAR(36) NOT NULL UNIQUE,
				date_created DATETIME NOT NULL,
				created_by CHAR(36) NOT NULL,
				date_modified DATETIME NOT NULL,
				modified_by CHAR(36) NOT NULL,
				reference_name VARCHAR(255) NOT NULL,
				real_name VARCHAR(255) NOT NULL,
				description TEXT NULL,
				file_reference VARCHAR(255) NOT NULL,
				`active` TINYINT(1) DEFAULT '0',
				PRIMARY KEY(id),
				FOREIGN KEY (created_by) REFERENCES ssx_user(id),
				FOREIGN KEY (modified_by) REFERENCES ssx_user(id)
			)ENGINE=innoDB;",
		'ssx_config'=>"CREATE TABLE IF NOT EXISTS `ssx_config`
			(
				id CHAR(36) NOT NULL UNIQUE,
				date_created DATETIME NOT NULL,
				created_by CHAR(36) NOT NULL,
				date_modified DATETIME NOT NULL,
				modified_by CHAR(36) NOT NULL,
				object_name VARCHAR(255) NOT NULL,
				object_value LONGTEXT NOT NULL,
				PRIMARY KEY(id),
				FOREIGN KEY (created_by) REFERENCES ssx_user(id),
				FOREIGN KEY (modified_by) REFERENCES ssx_user(id)
			)ENGINE=innoDB;",
		'ssx_pages'=>"CREATE TABLE IF NOT EXISTS `ssx_pages`
			(
				id CHAR(36) NOT NULL UNIQUE,
				date_created DATETIME NOT NULL,
				created_by CHAR(36) NOT NULL,
				date_modified DATETIME NOT NULL,
				modified_by CHAR(36) NOT NULL,
				title VARCHAR(255) NOT NULL,
				slug VARCHAR(255) NOT NULL,
				content LONGTEXT NOT NULL,
				status TINYINT(1) NULL DEFAULT '1',
				PRIMARY KEY(id),
				FOREIGN KEY (created_by) REFERENCES ssx_user(id),
				FOREIGN KEY (modified_by) REFERENCES ssx_user(id)
			)ENGINE=innoDB;"
	);
}
