<?php
namespace Custom\FormFetchPlugin\Model;

use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\Context;
use Magento\Framework\Registry;
use Magento\Framework\DataObject\IdentityInterface;
use Custom\FormFetchPlugin\Model\ResourceModel\FormData as ResourceModel;

class FormData extends AbstractModel implements IdentityInterface
{
    const CACHE_TAG = 'form_fetch_plugin_data';

    protected $_idFieldName = 'email'; // Primary key is email
    protected $_cacheTag = self::CACHE_TAG;
    protected $_resourceModel = ResourceModel\FormData::class;

    protected $_fieldMapping = [
        'email' => 'email',
        'first_name' => 'first_name',
        'last_name' => 'last_name',
        'school_name' => 'school_name',
    ];

    protected $email;
    protected $firstName;
    protected $lastName;
    protected $schoolName;

    public function _construct()
    {
        parent::_construct();
        $this->_init(ResourceModel\FormData::class);
    }

    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
        return $this;
    }

    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
        return $this;
    }

    public function setSchoolName($schoolName)
    {
        $this->schoolName = $schoolName;
        return $this;
    }

    public function getId()
    {
        return $this->email;
    }

    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }
}
