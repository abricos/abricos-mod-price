<?php
/**
 * @package Abricos
 * @subpackage Price
 * @copyright 2015 Alexander Kuzmin
 * @license http://opensource.org/licenses/mit-license.php MIT License
 * @author Alexander Kuzmin <roosit@abricos.org>
 */

/**
 * Class PriceQuery
 */
class PriceQuery {

    public static function FileAppend(PriceApp $app, $filehash, $title){
        $db = $app->db;
        $sql = "
            INSERT INTO ".$db->prefix."price_file
            (userid, filehash, title, dateline) VALUES (
                ".intval(Abricos::$user->id).",
                '".bkstr($filehash)."',
                '".bkstr($title)."',
                ".TIMENOW."
            )
        ";
        $db->query_write($sql);
        return $db->insert_id();
    }

    public static function File(PriceApp $app){
        $db = $app->db;
        $sql = "
            SELECT *
            FROM ".$db->prefix."price_file
            ORDER BY dateline DESC
            LIMIT 1
        ";
        return $db->query_first($sql);
    }

}

?>

