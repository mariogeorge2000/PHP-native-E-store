<?php

namespace PHPMVC\models;
require_once 'abstractmodel.php';


class UserGroupModel extends AbstractModel
{
    public $GroupID;
    public $GroupName;


    protected static $primaryKey = 'GroupId';
    protected static $tableName = 'app_users_groups';
    protected static $tableSchema = array(

        'GroupId' => self::DATA_TYPE_INT,
        'GroupName' => self::DATA_TYPE_STR,
);

}