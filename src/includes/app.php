<?php
/**
 * @package Abricos
 * @subpackage Price
 * @copyright 2015 Alexander Kuzmin
 * @license http://opensource.org/licenses/mit-license.php MIT License
 * @author Alexander Kuzmin <roosit@abricos.org>
 */

/**
 * Class PriceManager
 *
 * @property PriceManager $manager
 */
class PriceApp extends AbricosApplication {

    protected function GetClasses(){
        return array(
            'Config' => 'PriceConfig',
            'File' => 'PriceFile',
            'FileList' => 'PriceFileList'
        );
    }

    protected function GetStructures(){
        return 'Config,File';
    }

    public function ResponseToJSON($d){
        switch ($d->do){
            case "file":
                return $this->FileToJSON();

            case "config":
                return $this->ConfigToJSON();
            case "configSave":
                return $this->ConfigSaveToJSON($d->config);

        }
        return null;
    }

    private $_cache = array();

    public function CacheClear(){
        $this->_cache = array();
    }

    public function FileToJSON(){
        $res = $this->File();
        return $this->ResultToJSON('file', $res);
    }

    /**
     * @return int|PriceFile
     */
    public function File(){
        if (isset($this->_cache['File'])){
            return $this->_cache['File'];
        }
        if (!$this->manager->IsViewRole()){
            return 403;
        }

        $d = PriceQuery::File($this);
        if (empty($d)){
            return 404;
        }

        /** @var PriceFile $file */
        $file = $this->InstanceClass('File', $d);
        return $this->_cache['File'] = $file;
    }

    public function FileAppend($filehash, $title){
        if (!$this->manager->IsAdminRole()){
            return 403;
        }
        $fileid = PriceQuery::FileAppend($this, $filehash, $title);

        $ret = new stdClass();
        $ret->fileid = $fileid;
        return $ret;
    }

    public function ConfigToJSON(){
        $res = $this->Config();
        return $this->ResultToJSON('config', $res);
    }

    /**
     * @return PriceConfig
     */
    public function Config(){
        if (isset($this->_cache['Config'])){
            return $this->_cache['Config'];
        }

        if (!$this->manager->IsViewRole()){
            return 403;
        }

        $phrases = $this->manager->module->GetPhrases();

        $d = array();
        for ($i = 0; $i < $phrases->Count(); $i++){
            $ph = $phrases->GetByIndex($i);
            $d[$ph->id] = $ph->value;
        }

        return $this->_cache['Config'] = $this->models->InstanceClass('Config', $d);
    }

    public function ConfigSaveToJSON($sd){
        $this->ConfigSave($sd);
        return $this->ConfigToJSON();
    }

    public function ConfigSave($sd){
        if (!$this->manager->IsAdminRole()){
            return 403;
        }

        $phs = $this->manager->module->GetPhrases();
        // $phs->Set("page_count", intval($sd->page_count));

        Abricos::$phrases->Save();
    }
}

?>