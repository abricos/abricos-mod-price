<?php
/**
 * @package Abricos
 * @subpackage Price
 * @copyright 2015 Alexander Kuzmin
 * @license http://opensource.org/licenses/mit-license.php MIT License
 * @author Alexander Kuzmin <roosit@abricos.org>
 */

$charset = "CHARACTER SET 'utf8' COLLATE 'utf8_general_ci'";
$updateManager = Ab_UpdateManager::$current;
$db = Abricos::$db;
$pfx = $db->prefix;

if ($updateManager->isInstall()){
    Abricos::GetModule('price')->permission->Install();

    $db->query_write("
		CREATE TABLE IF NOT EXISTS ".$pfx."price_file (
		  fileid int(10) unsigned NOT NULL auto_increment,
		  userid int(10) unsigned NOT NULL,

		  filehash varchar(8) NOT NULL,

		  title varchar(200) NOT NULL,

		  dateline int(10) unsigned NOT NULL default 0,
		  deldate int(10) unsigned NOT NULL default 0,

		  PRIMARY KEY (fileid),
		  KEY deldate (deldate)
		)".$charset
    );
}


?>