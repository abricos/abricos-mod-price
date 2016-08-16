<?php
/**
 * @package Abricos
 * @subpackage Price
 * @copyright 2015 Alexander Kuzmin
 * @license http://opensource.org/licenses/mit-license.php MIT License
 * @author Alexander Kuzmin <roosit@abricos.org>
 */

$brick = Brick::$builder->brick;
$brick->param->var['url'] = Abricos::$adress->requestURI;

$p_act = Abricos::CleanGPC('p', 'act', TYPE_STR);
if ($p_act != "upload"){
    return;
}

$modFM = Abricos::GetModule('filemanager');
if (empty($modFM)){
    return;
}

$fmManager = $modFM->GetFileManager();

/** @var PriceApp $app */
$app = Abricos::GetModule('price')->GetManager()->GetApp();

// отключить проверку ролей в менеджере файлов
$fmManager->RolesDisable();
// отключить проверку свободного места в профиле пользователя
$fmManager->CheckSizeDisable();

$upload = FileManagerModule::$instance->GetManager()->CreateUploadByVar('file0');
$upload->ignoreUploadRole = true;

$errornum = $upload->Upload();

if ($errornum === 0){
    $app->FileAppend($upload->uploadFileHash, $upload->fileName);
}else{
    print_r($errornum);
}

$dir = Abricos::$adress->dir;

$brick->param->var['command'] = Brick::ReplaceVarByData($brick->param->var['ok'], array(
    "idWidget" => isset($dir[2]) ? $dir[2] : '',
    "fid" => $upload->uploadFileHash
));
