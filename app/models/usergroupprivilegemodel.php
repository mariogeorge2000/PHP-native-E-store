<?php

namespace PHPMVC\models;
require_once 'abstractmodel.php';


class UserGroupPrivilegeModel extends AbstractModel
{
    public $Id;
    public $GroupID;
    public $PrivilegeId;


    protected static $primaryKey = 'Id';

    protected static $tableName = 'app_users_groups_privileges';
    protected static $tableSchema = array(

        'GroupId' => self::DATA_TYPE_INT,
        'PrivilegeId' => self::DATA_TYPE_INT
);

    public static function getGroupPrivilege(UserGroupModel $group)
    {
        $groupPrivileges            = self::getBy(['group_id'=> $group->group_id]);
        $extractedPrivilegesIds = [];
        if(false !==$groupPrivileges){
            foreach ($groupPrivileges as $privilege){
                $extractedPrivilegesIds[] =$privilege->privilege_id;
            }
        }
        return $extractedPrivilegesIds;
    }

    public static function getPrivilegesForGroup($group_id)
    {
        $sql  =' SELECT augp.* ,aup.Privilege FROM '.self::$tableName .' as augp ';
        $sql .=' INNER JOIN app_users_privileges aup ON aup.PrivilegeId =  augp.PrivilegeId';
        $sql .=' WHERE augp.group_id ='.$groupId ;


        $privileges = self::get($sql);
        $extractedUrls =[];
        if(false !==$privileges){
            foreach ($privileges as $privilege){
                $extractedUrls[] =$privilege->privilege;
            }
        }
        return $extractedUrls;
    }
}
