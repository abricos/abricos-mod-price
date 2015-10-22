<?php
/**
 * @package Abricos
 * @subpackage Price
 * @copyright 2015 Alexander Kuzmin
 * @license http://opensource.org/licenses/mit-license.php MIT License
 * @author Alexander Kuzmin <roosit@abricos.org>
 */

$brick = Brick::$builder->brick;
$p = &$brick->param->param;
$v = &$brick->param->var;

/** @var PriceApp $app */
$app = Abricos::GetModule('price')->GetManager()->GetApp();
$file = $app->File();

$brick->content = empty($file) ? "#" : "/filemanager/i/".$file->filehash."/".$file->title;

?>