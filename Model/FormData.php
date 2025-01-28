<?php

namespace Custom\FormFetchPlugin\Model;

use Magento\Framework\Model\AbstractModel;

class FormData extends AbstractModel
{
    protected $_idFieldName = 'email';  // Replace with your primary key field name
    protected $_table = 'form_fetch_plugin_data';  // Define the database table name where data will be saved

    protected $_dataModel = \Custom\FormFetchPlugin\Model\ResourceModel\FormData::class;

    // Define getters and setters for your form data attributes
    public function getEmail() {
        return $this->_getData('email');
    }

    public function setEmail($email) {
        $this->setData('email', $email);
    }

    public function getFirstName() {
        return $this->_getData('firstname');
    }

    public function setFirstName($firstname) {
        $this->setData('firstname', $firstname);
    }

    public function getLastName() {
        return $this->_getData('lastname');
    }

    public function setLastName($lastname) {
        $this->setData('lastname', $lastname);
    }

    public function getSchoolName() {
        return $this->_getData('schoolname');
    }

    public function setSchoolName($schoolname) {
        $this->setData('schoolname', $schoolname);
    }
}
