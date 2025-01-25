<?php
class CommonController extends Zend_Controller_Action {
    protected function getCookie($key){
        return $this->getRequest()->getCookie($key);
    }

    protected function setCookie($key, $value){
        setCookie($key, $value, time() + Constant::COOKIE_TIMEOUT, Constant::COOKIE_PATH);
    }

    protected function getMenuCookie($menu){
        return $this->getRequest()->getCookie($menu);
    }

    protected function setMenuCookie($key, $value){
        setCookie($key, $value, time() + Constant::COOKIE_TIMEOUT_ONEYEAR, Constant::COOKIE_PATH);
    }
}