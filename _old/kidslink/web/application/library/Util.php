<?php
class Util {
    /**
     * 文字コードをUTF-8からSJISに変更
     * @param unknown_type $val
     */
    public static function convertUTF8_SJIS($val){
        return mb_convert_encoding($val, 'SJIS', 'UTF-8');
    }

   /**
     * 文字コードをUTF-8からSJIS-winに変更
     * @param unknown_type $val
     */
    public static function convertUTF8_SJISwin($val){
        return mb_convert_encoding($val, 'SJIS-win', 'UTF-8');
    }

    /**
     * 文字コードをSJISからUTF-8に変更
     * @param unknown_type $val
     */
    public static function convertSJIS_UTF8($val){
        return mb_convert_encoding($val, 'UTF-8', 'SJIS');
    }

    /**
     * 文字コードをSJIS-winからUTF-8に変更
     * @param unknown_type $val
     */
    public static function convertSJISwin_UTF8($val){
        return mb_convert_encoding($val, 'UTF-8', 'SJIS-win');
    }

    public static function convertIBM_EXT_STR($org){
        $tmp = self::convertSJISwin_UTF8($org);
        //$ibm1 = array('髙','﨑','桒');
        //$ibm2 = array('高','崎','桑');
        $ibm1 = array('髙','﨑');
        $ibm2 = array('高','崎');
        for($i=0;$i<count($ibm1);$i++){
            $tmp = str_replace($ibm1[$i],$ibm2[$i],$tmp);
        }

        return $tmp;
    }

    public static function xmlToArray($xml, &$return, $path='', $root=false)
    {
        $children = array();
        if ($xml instanceof SimpleXMLElement) {
            $children = $xml->children();
            if ($root){
                $path .= '/'.$xml->getName();
            }
        }
        if ( count($children) == 0 ){
            $return[$path] = (string)$xml;
            return;
        }
        $seen = array();
        foreach ($children as $child => $value) {
            $childname = ($child instanceof SimpleXMLElement)?$child->getName():$child;
            /*if ( !isset($seen[$childname])){
                $seen[$childname] = 0;
            }
            $seen[$childname]++;
            XMLToArrayFlat($value, $return, $path.'/'.$child.'['.$seen[$childname].']');*/
            Util::xmlToArray($value, $return, $child);
        }
    }

    public static function arrToStr( $glue, $pieces )
    {
        if( is_array( $pieces ) )
        {
            foreach( $pieces as $key => $r_pieces )
            {
                if( is_array( $r_pieces ) )
                {
                    $retVal[] = Util::arrToStr( $glue, $r_pieces );
                }
                else
                {
                    $retVal[] = "[$key]=".$r_pieces;
                }
            }
        }
        return implode( $glue, $retVal );
    }

    public static function endsWith($string, $char)
    {
        $length = strlen($char);
        $start =  $length *-1; //negative
        return (substr($string, $start, $length) === $char);
    }

    public static function chg5CStr($org, $utf8=true){
        if($utf8){
            for($i=0;$i<count($org);$i++){
                $org[$i] = self::convertSJIS_UTF8($org[$i]);
            }
        }
        $src = array('表','予','能','申','ソ','十','構','暴','圭','貼',
                     '噂','浬','欺','蚕','曾','箪','禄','兔','喀','媾',
                     '―' ,'彌','拿','杤','歃','濬','畚','秉','綵','臀',
                     '藹','觸','軆','鐔','饅','鷭');
        for($i=0;$i<count($org);$i++){
            $lastStr = mb_substr($org[$i], -1);
            for($j=0;$j<count($src);$j++){
                if($lastStr == $src[$j]){
                    $org[$i] = $org[$i].' ';
                }
            }
            $org[$i] = self::convertUTF8_SJIS($org[$i]);
        }

        return $org;
    }

    public static function chg5CStr_win($org, $utf8=true){
        if($utf8){
            for($i=0;$i<count($org);$i++){
                $org[$i] = self::convertSJISwin_UTF8($org[$i]);
            }
        }
        $src = array('表','予','能','申','ソ','十','構','暴','圭','貼',
                     '噂','浬','欺','蚕','曾','箪','禄','兔','喀','媾',
                     '―' ,'彌','拿','杤','歃','濬','畚','秉','綵','臀',
                     '藹','觸','軆','鐔','饅','鷭');
        for($i=0;$i<count($org);$i++){
            $lastStr = mb_substr($org[$i], -1);
            for($j=0;$j<count($src);$j++){
                if($lastStr == $src[$j]){
                    $org[$i] = $org[$i].' ';
                }
            }
            $org[$i] = self::convertUTF8_SJISwin($org[$i]);
        }

        return $org;
    }
}