<?php
class Message {
    const OK                       = 0;
    const ServerRefusedKey         = 1;
    const InvalidData              = 2;
    const NotFound                 = 3;
    const RegistrationError        = 4;
    const XmlParsingError          = 5;
    const UpdateError              = 6;
    const NetworkConnectionError   = 7;
    const XMLSchemaError           = 8;
    const IDMRegistrationError     = 9;
    const IDMDuplicateError        = 10;
    const IDdoseNotExist           = 11;
    const ConnectionTimeOut        = 12;
    const NetworkConnectionTimeOut = 13;
    const DBError                  = 14;
    const NoActionException        = -1;
    const NoControlException       = -2;
    const NotSynchError            = -99;

    private static $message_array = array(
        '1' => 'Server Refused Key',
        '2' => 'Invalid data',
        '3' => 'Not Found',
        '4' => 'Registration Error',
        '5' => 'XML Parsing Error',
        '6' => 'Update Error',
        '7' => 'Network Connection Error',
        '8' => 'XML Schema Error',
        '9' => 'IDM Registration Error',
        '10' => 'IDM Duplicate Error',
        '11' => 'ID dose not exist',
        '12' => 'Connection TimeOut',
        '13' => 'Network Connection TimeOut',
        '14' => 'DB Error',
        '-1' => 'NoActionException',
        '-2' => 'NoControlException',
        '-99' => 'NotSynchError',
    );

    public static function getMessage($result){
        if(isset($result['message'])){
            return $result['message'];
        }else{
            return isset(self::$message_array[$result['status']]) ? self::$message_array[$result['status']] : '';
        }
    }
}