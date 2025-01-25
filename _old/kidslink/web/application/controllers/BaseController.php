<?php
require_once 'CommonController.php';
require_once APPLICATION_PATH.'/models/SelectDAO.php';
require_once APPLICATION_PATH.'/models/UpdateDAO.php';

class BaseController extends CommonController {
    protected $selectDAO;
    protected $updateDAO;

    public function init(){
        //$this->_helper->layout->disableLayout();
        $this->selectDAO = new SelectDAO();
        $this->updateDAO = new UpdateDAO();

        /*$logger = new Logger(__CLASS__, __FUNCTION__);

        $loginFlag = $this->getCookie(Constant::LOGIN_FLAG);
        if($loginFlag == null || $loginFlag == ''){
            $logger->info('login fail, go to loginform');
            $this->_redirect('secure/login');
        }*/
    }
}