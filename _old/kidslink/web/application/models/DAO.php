<?php
require_once 'DbManager.php';
class DAO {
    protected function getSelectConnection(){
        return DbManager::getConnection(0);
    }

    protected function getUpdateConnection(){
        return DbManager::getConnection(1);
    }
}