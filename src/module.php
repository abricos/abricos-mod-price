<?php
/**
 * @package Abricos
 * @subpackage Price
 * @copyright 2015 Alexander Kuzmin
 * @license http://opensource.org/licenses/mit-license.php MIT License
 * @author Alexander Kuzmin <roosit@abricos.org>
 */


/**
 * Class PriceModule
 */
class PriceModule extends Ab_Module {

    public function PriceModule(){
        $this->version = "0.1.0";
        $this->name = "price";
        $this->takelink = "price";

        $this->permission = new PricePermission($this);
    }

    private $_manager = null;

    public function GetManager(){
        if (is_null($this->_manager)){
            require_once 'includes/manager.php';
            $this->_manager = new PriceManager($this);
        }
        return $this->_manager;
    }

    public function GetContentName(){
        $adress = Abricos::$adress;
        if ($adress->level >= 2 && $adress->dir[1] === 'upload'){
            return "upload";
        }
        return '';
    }

    public function Bos_IsMenu(){
        return true;
    }
}


class PriceAction {
    const VIEW = 10;
    const WRITE = 30;
    const ADMIN = 50;
}

class PricePermission extends Ab_UserPermission {

    public function __construct(PriceModule $module){
        $defRoles = array(
            new Ab_UserRole(PriceAction::VIEW, Ab_UserGroup::GUEST),
            new Ab_UserRole(PriceAction::VIEW, Ab_UserGroup::REGISTERED),
            new Ab_UserRole(PriceAction::VIEW, Ab_UserGroup::ADMIN),

            new Ab_UserRole(PriceAction::WRITE, Ab_UserGroup::ADMIN),
            new Ab_UserRole(PriceAction::ADMIN, Ab_UserGroup::ADMIN)
        );
        parent::__construct($module, $defRoles);
    }

    public function GetRoles(){
        return array(
            PriceAction::VIEW => $this->CheckAction(PriceAction::VIEW),
            PriceAction::WRITE => $this->CheckAction(PriceAction::WRITE),
            PriceAction::ADMIN => $this->CheckAction(PriceAction::ADMIN)
        );
    }
}

Abricos::ModuleRegister(new PriceModule());

?>