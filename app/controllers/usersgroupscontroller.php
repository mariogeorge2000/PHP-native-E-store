<?php

namespace PHPMVC\Controllers;

use PHPMVC\lib\Helper;
use PHPMVC\lib\InputFilter;
use PHPMVC\models\privilegeModel;
use PHPMVC\models\UserGroupModel;
use PHPMVC\models\UserGroupPrivilegeModel;


class UsersGroupsController extends AbstractController
{
    use Helper;
    use InputFilter;
    public function defaultAction()
    {
        $this->language->load('template.common');
        $this->language->load('usersgroups.default');
        $this->_data['groups']=UserGroupModel::getAll();
        $this->_view();
    }
    public function createAction()
    {
        $this->language->load('template.common');
        $this->language->load('usersgroups.create');
        $this->language->load('usersgroups.labels');

        $this->_data['privileges']=privilegeModel::getAll();
        if(isset($_POST['submit'])){
            $group = new UserGroupModel();
            $group->group_name = $this->filterString($_POST['group_name']);
            if($group->save()){

                if(isset($_POST['privileges'])&& is_array($_POST['privileges'])){
                    foreach ($_POST['privileges'] as $privilegeId){
                        $groupPrivilege = new UserGroupPrivilegeModel();
                        $groupPrivilege->group_id = $group->group_id;
                        $groupPrivilege->privilege_id = $privilegeId;
                        $groupPrivilege->save();
                    }
                }
                $this->redirect('/usersgroups');
            }
        }


        $this->_view();
    }

    public function editAction()
    {
        $id=$this->filterString($this->_params[0]);
        $group = UserGroupModel::getByPK($id);
        if($group == false){
            $this->redirect('/usersgroups');
        }
        $this->language->load('template.common');
        $this->language->load('usersgroups.edit');
        $this->language->load('usersgroups.labels');

        $this->_data['group']       = $group;
        $this->_data['privileges']  = privilegeModel::getAll();
        $extractedPrivilegesIds =  $this->_data['groupPrivileges'] =UserGroupPrivilegeModel::getGroupPrivilege($group);



        if(isset($_POST['submit'])){
            $group = new UserGroupModel();
            $group->group_id = $id;
            $group->group_name = $this->filterString($_POST['group_name']);
            if($group->save()){


                if(isset($_POST['privileges'])&& is_array($_POST['privileges'])){
                    $privilegesIdsToBeDeleted = array_diff(  $extractedPrivilegesIds , $_POST['privileges']);
                    $privilegesIdsToAdded = array_diff($_POST['privileges'] , $extractedPrivilegesIds);

                    //Delete the unwanted privileges
                    foreach ($privilegesIdsToBeDeleted as $deletedPrivilege){
                        $unwantedPriviege = UserGroupPrivilegeModel::getBy([
                            'privilege_id'  => $deletedPrivilege,
                            'group_id'      => $group->group_id
                        ]);

                        $unwantedPriviege->current()->delete();
                    }

                    //Add the new privileges
                    foreach($privilegesIdsToAdded as $privilegeId){
                        $groupPrivilege = new UserGroupPrivilegeModel();
                        $groupPrivilege->group_id = $group->group_id;
                        $groupPrivilege->privilege_id = $privilegeId;
                        $groupPrivilege->save();
                    }
                    $this->redirect('/usersgroups');
                }
            }
        }


        $this->_view();
    }
    public function deleteAction()
    {
        $id=$this->filterString($this->_params[0]);
        $group = UserGroupModel::getByPK($id);
        if($group == false){
            $this->redirect('/usersgroups');
        }

        $groupPrivileges=UserGroupPrivilegeModel::getBy(['group_id'=> $group->group_id]);
        if(false !== $groupPrivileges){
            foreach ($groupPrivileges as $groupPrivilege){
                $groupPrivilege->delete();
            }
        }
        if($group->delete()){
            $this->redirect('/usersgroups');
        }


    }
}