<?php

namespace PHPMVC\Controllers;

use PHPMVC\lib\FileUpload;
use PHPMVC\lib\Helper;
use PHPMVC\lib\InputFilter;
use PHPMVC\lib\Messenger;
use PHPMVC\lib\Validate;
use PHPMVC\models\privilegeModel;
use PHPMVC\Models\ProductCategoryModel;
use PHPMVC\models\UserGroupModel;
use PHPMVC\models\UserGroupPrivilegeModel;


class ProductCategoriesController extends AbstractController
{
    use Helper;
    use InputFilter;
    use Validate;

    private $_createActionRoles =
        [
            'Name'          => 'req|alphanum|between(3,30)'
        ];

    public function defaultAction()
    {
        $this->language->load('template.common');
        $this->language->load('productcategories.default');
        $this->_data['categories']=ProductCategoryModel::getAll();
        $this->_view();
    }
    public function createAction()
    {
        $this->language->load('template.common');
        $this->language->load('productcategories.create');
        $this->language->load('productcategories.labels');
        $this->language->load('productcategories.messages');
        $this->language->load('validation.errors');

        $uploadError=false;

        if(isset($_POST['submit']) && $this->isValid($this->_createActionRoles, $_POST)){
            $category = new ProductCategoryModel();
             $category->Name = $this->filterString($_POST['Name']);
           if (!empty($_FILES['image']['name'])) {
               $uploader = new FileUpload($_FILES['image']);
               try {
                   $uploader->upload();
                   $category->Image=$uploader->getFileName();
               } catch (\Exception $e){
                   $this->messenger->add($e->getMessage(), Messenger::APP_MESSAGE_ERROR);
                   $uploadError= true;
               }
           }
            if($uploadError===false && $category->save()){
                $this->messenger->add($this->language->get('message_create_success'));
                $this->redirect('/productcategories');

            } else{
                $this->messenger->add($this->language->get('message_create_failed'), Messenger::APP_MESSAGE_ERROR);

            }
        }


        $this->_view();
    }

    public function editAction()
    {
        $id=$this->filterString($this->_params[0]);
        $category = ProductCategoryModel::getByPK($id);
        if($category == false){
            $this->redirect('/productcategories');
        }
        $this->language->load('template.common');
        $this->language->load('productcategories.edit');
        $this->language->load('productcategories.labels');
        $this->language->load('productcategories.messages');
        $this->language->load('validation.errors');

        $this->_data['category']  = $category;
        $uploadError=false;

        if(isset($_POST['submit'])){
            $category->Name = $this->filterString($_POST['Name']);
           if (!empty($_FILES['image']['name'])) {
               //remove the old image
               if($category->Image !== '' && file_exists(IMAGES_UPLOAD_STORAGE . DS . $category->Image) &&
                   is_writable(IMAGES_UPLOAD_STORAGE)) {
                   unlink(IMAGES_UPLOAD_STORAGE . DS . $category->Image);
               }
               //create new image
                   $uploader = new FileUpload($_FILES['image']);
                   try {
                       $uploader->upload();
                       $category->Image=$uploader->getFileName();
                   } catch (\Exception $e){
                       $this->messenger->add($e->getMessage(), Messenger::APP_MESSAGE_ERROR);
                       $uploadError= true;
                   }
           }

            if($uploadError===false && $category->save()){
                $this->messenger->add($this->language->get('message_create_success'));
                $this->redirect('/productcategories');

            } else{
                $this->messenger->add($this->language->get('message_create_failed'),Messenger::APP_MESSAGE_ERROR);

            }
        }


        $this->_view();
    }
    public function deleteAction()
    {
        $id=$this->filterString($this->_params[0]);
        $category = ProductCategoryModel::getByPK($id);
        if($category == false){
            $this->redirect('/productcategories');
        }

        $this->language->load('productcategories.messages');

        if($category->delete()){
            //remove the old image
            if($category->Image !== '' && file_exists(IMAGES_UPLOAD_STORAGE . DS . $category->Image) &&
                is_writable(IMAGES_UPLOAD_STORAGE)) {
                unlink(IMAGES_UPLOAD_STORAGE . DS . $category->Image);
            }
            $this->messenger->add($this->language->get('message_delete_success'));

        } else{
            $this->messenger->add($this->language->get('message_delete_failed'));

        }
        $this->redirect('/productcategories');

    }
}