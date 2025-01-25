<?php
require_once 'DAO.php';
require_once APPLICATION_PATH.'/library/Util.php';

class SelectDAO extends DAO{
    public function getAccessData($member_id) {
        $con = parent::getSelectConnection();
        $query  = " call access(?,'ja') ";
        $stmt = $con->query($query,array($member_id));
        return $stmt;
    }
}