<?php

namespace PHPMVC\models;
require_once 'abstractmodel.php';


class UserModel extends AbstractModel
{
    public $UserId;
    public $Username;
    public $Password;
    public $Email;
    public $PhoneNumber;
    public $SubscriptionDate;
    public $LastLogin;
    public $GroupId;
    public $Status;

    /**
     * @var UserProfileModel
     */
    public $profile; //object mn UserProfileModel
    public $privileges;

    protected static $primaryKey = 'UserId';
    protected static $tableName = 'app_users';
    protected static $tableSchema = array(

        'UserId' => self::DATA_TYPE_INT,
        'UserName' => self::DATA_TYPE_STR,
        'Password' => self::DATA_TYPE_STR,
        'Email' => self::DATA_TYPE_STR,
        'PhoneNumber' => self::DATA_TYPE_STR,
        'SubscriptionDate' => self::DATA_TYPE_DATE,
        'LastLogin' => self:: DATA_TYPE_STR,
         'GroupId' => self:: DATA_TYPE_INT,
        '$Status'=> self:: DATA_TYPE_INT,
);

    public function cryptPassword($password)
    {
        $this->password = crypt($password ,APP_SALT); //app salt de defined f config file
    }

    public static function getUsers(UserModel $user) //da 3ashan ta5od el group id mn users group model
    {
        return self::get(
            'SELECT au.*, aug.GroupName GroupName FROM '. self::$tableName . ' au INNER JOIN app_users_groups aug ON aug.GroupId = au.GroupId WHERE au.UserId != ' .$user->UserId //a5er 7eta de 3ashan el user w howa 3amel login tshof kol el users el tanyeen fel form 2ela howa nfso
        );
    }
    public static function userExists($username)
    {
        return self::get('    SELECT * FROM ' . self::$tableName . ' WHERE user_name = "' . $username . '"
  ');
    }
    public static function authenticate($username, $password, $session)
    {
        $password=crypt($password,APP_SALT);
        $sql = 'SELECT *,
        (SELECT GroupName FROM app_users_groups WHERE app_users_groups.GroupId ='.self::$tableName.'.GroupId) 
             as GroupName FROM '.self::$tableName.' WHERE UserName= "'.$username.'" AND Password="'.$password.'"';

        $foundUser=self::getOne($sql);
        if (false!==$foundUser)
        {
            if ($foundUser->Status==2){
                return 2;
            }
            $foundUser->LastLogin=date('Y-m-d H:i:s');
            $foundUser->save();
            $foundUser->profile=UserProfileModel::getByPK($foundUser->UserId); //3ayez ageb el profile bta3 el user w eb2a m3aya
            $foundUser->privileges=UserGroupPrivilegeModel::getPrivilegesForGroup($foundUser->GroupId);
            $session->u=$foundUser; //kda 7atena fel session kol 7ager el user w el userProfile..kda u de shayla userdata w object mn el userProfileModel (profile)
            return 1;
        }
        return false;
    }

}