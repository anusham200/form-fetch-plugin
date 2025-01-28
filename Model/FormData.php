namespace Custom\FormFetchPlugin\Model;

use Magento\Framework\Model\AbstractModel;
use Custom\FormFetchPlugin\Model\ResourceModel\FormData as FormDataResource;

class FormData extends AbstractModel
{
    protected $_idFieldName = 'email';  // Use primary key as email
    protected $_table = 'form_fetch_plugin_data';  // The table name

    protected $_resourceModel = FormDataResource::class;

    // Setters and Getters for the form fields
    public function getEmail() {
        return $this->_getData('email');
    }

    public function setEmail($email) {
        return $this->setData('email', $email);
    }

    public function getFirstName() {
        return $this->_getData('firstname');
    }

    public function setFirstName($firstname) {
        return $this->setData('firstname', $firstname);
    }

    public function getLastName() {
        return $this->_getData('lastname');
    }

    public function setLastName($lastname) {
        return $this->setData('lastname', $lastname);
    }

    public function getSchoolName() {
        return $this->_getData('schoolname');
    }

    public function setSchoolName($schoolname) {
        return $this->setData('schoolname', $schoolname);
    }
}
