<?php
namespace Custom\FormFetchPlugin\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class FormData extends AbstractDb
{
    protected $_idFieldName = 'email'; // Primary key is email
    protected $_table = 'form_fetch_plugin_data'; // Your table name

    protected function _construct()
    {
        $this->_init('Custom\FormFetchPlugin\Model\ResourceModel\FormData', 'email');
    }
}
