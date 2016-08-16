<?php
/**
 * @package Abricos
 * @subpackage Price
 * @copyright 2015 Alexander Kuzmin
 * @license http://opensource.org/licenses/mit-license.php MIT License
 * @author Alexander Kuzmin <roosit@abricos.org>
 */

/**
 * Class PriceFile
 *
 * @property string $filehash
 * @property string $title
 * @property int $dateline
 */
class PriceFile extends AbricosModel {
    protected $_structModule = 'price';
    protected $_structName = 'File';
}

/**
 * Class PriceList
 * @method PriceFile Get($fileid)
 * @method PriceFile GetByIndex($index)
 */
class PriceList extends AbricosModelList {

}

/**
 * Class PriceConfig
 */
class PriceConfig extends AbricosModel {
    protected $_structModule = 'price';
    protected $_structName = 'Config';
}
