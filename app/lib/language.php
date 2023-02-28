<?php
namespace PHPMVC\lib;

class Language
{
    private $dictionary = [];

    public function load($path)
    {
        $defaultLanguage = APP_DEFAULT_LANGUAGE;
        if(isset($_SESSION['lang'])){
            $defaultLanguage = $_SESSION['lang'];
        }
        $pathArray=explode('.',$path);
        $languageFileToload = LANGUAGES_PATH . $defaultLanguage . DS . $pathArray[0] . DS . $pathArray[1] .'.lang.php';
        if(file_exists($languageFileToload)){
            require $languageFileToload;

            if(is_array($_)&&!empty($_)){
                foreach ($_ as $key=>$value){
                    $this->dictionary[$key]=$value;
                }
            }

        }
        else {
            trigger_error('Sorry the language file ' . $path . ' doens\'t exists', E_USER_WARNING);
        }
    }

    public  function get($key)
    {
        if(array_key_exists($key , $this->dictionary)){
            return $this->dictionary[$key];
        }
    }
    public function feedKey($key , $data) //bnst5dm de f validate
    {
        if(array_key_exists($key , $this->dictionary)){
            array_unshift($data ,$this->dictionary[$key]);
            return call_user_func_array('sprintf',$data);
        }
    }

    public function getDictionary()
    {
        return $this->dictionary;
    }

}