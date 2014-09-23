<?php

class Robinhq_Robin_Adminhtml_RobinbackendController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
       $this->loadLayout();
       $this->_title($this->__('Robin'));
       $this->renderLayout();
    }

    public function configAction()
    {
       $apikey = $this->generateApiKey();
       $user = Mage::getModel('api/user')->loadByUserName('robin_api_consumer');

       if ($user->getId())
       {
          $roleIds = $user->getRoles(); 
          foreach ($roleIds as $roleId) {
            $role = Mage::getModel('api/roles');
            $role->load($roleId);
            $role->delete();
          }
   
          $user->delete();
          $this->addRoleAndUser($apikey);
       }
       else
       {  
          $this->addRoleAndUser($apikey);
       }
       
        $json = array(
            'apiKey' => $apikey,
            'apiConsumer' => 'robin_api_consumer'
        );

        $this->adjustSoapApiSettings();
        
        $this->getResponse()->setHeader('Content-type', 'application/json');
        $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($json));
    }

    function addRoleAndUser($apikey)
    {

        $role = Mage::getModel('api/roles')
        ->setName('api_consumers')
        ->setPid(false)
        ->setRoleType('G')
        ->save();

        Mage::getModel("api/rules")
        ->setRoleId($role->getId())
        ->setResources(array('all'))
        ->saveRel();

        $user = Mage::getModel('api/user');
        $user->setData(array(
        'username' => 'robin_api_consumer',
        'firstname' => 'robin',
        'lastname' => 'robinhq',
        'email' => 'magento-apiconsumer@robinhq.com',
        'api_key' => $apikey ,
        'api_key_confirmation' => $apikey,
        'is_active' => 1,
        'user_roles' => '',
        'assigned_user_role' => '',
        'role_name' => '',
        'roles' => array($role->getId())
        ));
        $user->save();

        $user->setRoleIds(array($role->getId()))
        ->setRoleUserId($user->getUserId())
        ->saveRelations();
    }

    function generateApiKey($length = 10) {
      $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
      $randomString = '';
      for ($i = 0; $i < $length; $i++) {
          $randomString .= $characters[rand(0, strlen($characters) - 1)];
      }
      return $randomString;
    }

    function adjustSoapApiSettings() {
        $enableSoapApiSwitch = new Mage_Core_Model_Config();
        /*
        *turns Use Web Server Rewrites on
        */
        $enableSoapApiSwitch ->saveConfig('web/seo/use_rewrites', "1", 'default', 0);
        $enableSoapApiSwitch ->saveConfig('api/config/compliance_wsi',"1", 'default', 0);

        /*
        *puts https:// at the beginning of the Secure Base Url 
        
        $originalSecureBaseUrl = Mage::getStoreConfig('web/secure/base_url');
        if (substr($originalSecureBaseUrl, 0, 8 ) === "http://")
        {
            $secureBaseUrl = str_ireplace("http://", "https://", $originalSecureBaseUrl);
            $enableSoapApiSwitch ->saveConfig('web/secure/base_url', secureBaseUrl, 'default', 0);
        }
        */
      }
}