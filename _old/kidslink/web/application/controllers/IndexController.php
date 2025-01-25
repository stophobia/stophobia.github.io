<?php
require_once APPLICATION_PATH.'/library/Logger.php';
require_once 'BaseController.php';

class IndexController extends BaseController
{

    public function init()
    {
    	parent::init();
    }

    public function indexAction()
    {
        $logger = new Logger(__CLASS__, __FUNCTION__);
        $logger->info(implode(", ", mb_detect_order()));
        try{
            $stmt = $this->selectDAO->getAccessData(78);
            if($rs = $stmt->fetch(Zend_DB::FETCH_NAMED)) {
                $logger->info('member_id:'.$rs['member_id'].', kids_id:'.$rs['kids_id'].', kids_name:'.$rs['kids_name']);
            }else{
                $logger->info('there is no data');
            }
        }catch(Exception $e){
            $logger->error($e->getMessage());
        }
    }
}