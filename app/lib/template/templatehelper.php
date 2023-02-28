<?php

namespace PHPMVC\Lib\template;

trait TemplateHelper //we use it in template class
{
    public function matchUrl($url)
    {
        return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) === $url;
    }

    public function labelFloat($fieldName, $object = null)
    {
        return ((isset($_POST[$fieldName]) && !empty($_POST[$fieldName])) ||
            (null !== $object && $object->$fieldName !== null)) ? 'class ="floated" ' : '';
    }

    public function showValue($fieldName, $object = null) //de 3ashan lma y2oli error f create form el data matro7sh mn el form w ab2a lazem arg3 aktbha tani
    {
        return isset($_POST[$fieldName]) ? $_POST[$fieldName] : (is_null($object) ? '' : $object->$fieldName);
    }

    public function selectedIf($fieldName ,$value, $object=null) //de hatshof en kan fel field name(حقل البيانات) feh value selected ?? sa3etha byrg3ha tani
    {
        return ((isset($_POST[$fieldName]) && $_POST[$fieldName] == $value) || (!is_null($object)
                && $object->$fieldName == $value)) ? 'selected="selected"' : '';
    }
}