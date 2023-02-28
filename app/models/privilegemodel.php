<?php

namespace PHPMVC\models;
require_once 'abstractmodel.php';


class PrivilegeModel extends AbstractModel
{
    public $PrivilegeID;
    public $Privilege;
    public $PrivilegeTitle;


    protected static $primaryKey = '$PrivilegeID';
    protected static $tableName = 'app_users_privileges';
    protected static $tableSchema = array(

        'PrivilegeID' => self::DATA_TYPE_INT,
        'Privilege' => self::DATA_TYPE_STR,
        'PrivilegeTitle' => self::DATA_TYPE_STR,
);

}