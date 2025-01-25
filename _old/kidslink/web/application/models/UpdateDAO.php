<?php
require_once 'DAO.php';
require_once APPLICATION_PATH.'/library/Util.php';

class UpdateDAO extends DAO{
    /**
     * カテゴリー追加
     * @param unknown_type $con
     */
    public function addCategory($con, $params) {
        $query  = ' call AddCategory(?,?,?,?,?) ';
        $stmt = $con->query($query,$params);
        if($rs = $stmt->fetch(Zend_DB::FETCH_NAMED)) {
            return $rs['RESULT'];
        }else{
            return '0';
        }
    }

    /**
     * 直接Update　Connectionを取得するメッソード
     * @see application/models/db/DAO#getUpdateConnection()
     */
    public function getUpdateConnection(){
        return parent::getUpdateConnection();
    }
}