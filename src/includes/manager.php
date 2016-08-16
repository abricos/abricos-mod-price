<?php
/**
 * @package Abricos
 * @subpackage Price
 * @copyright 2015 Alexander Kuzmin
 * @license http://opensource.org/licenses/mit-license.php MIT License
 * @author Alexander Kuzmin <roosit@abricos.org>
 */

class PriceManager extends Ab_ModuleManager {

    /**
     *
     * @var PriceModule
     */
    public $module = null;

    public function IsAdminRole(){
        return $this->IsRoleEnable(PriceAction::ADMIN);
    }

    public function IsWriteRole(){
        if ($this->IsAdminRole()){
            return true;
        }
        return $this->IsRoleEnable(PriceAction::WRITE);
    }

    public function IsViewRole(){
        if ($this->IsWriteRole()){
            return true;
        }
        return $this->IsRoleEnable(PriceAction::VIEW);
    }

    private $_app = null;

    /**
     * @return PriceApp
     */
    public function GetApp() {
        if (empty($this->_app)) {
            require_once 'models.php';
            require_once 'dbquery.php';
            require_once 'app.php';
            $this->_app = new PriceApp($this);
        }
        return $this->_app;
    }

    public function AJAX($d) {
        return $this->GetApp()->AJAX($d);
    }

    public function Bos_MenuData(){
        if (!$this->IsAdminRole()){
            return null;
        }
        $i18n = $this->module->I18n();
        return array(
            array(
                "name" => "price",
                "title" => $i18n->Translate('title'),
                "icon" => "/modules/price/img/logo-48x48.png",
                "url" => "price/wspace/ws",
                "parent" => "controlPanel"
            )
        );
    }
}
