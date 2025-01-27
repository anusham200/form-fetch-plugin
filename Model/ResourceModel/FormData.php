<?php
namespace Custom\FormFetchPlugin\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class FormData extends AbstractDb
{
    protected function _construct()
    {
        // The first parameter is the table name, and the second is the primary key column
        $this->_init('form_fetch_plugin_data', 'email'); // Replace 'form_data_table' with your actual database table name
    }
}
