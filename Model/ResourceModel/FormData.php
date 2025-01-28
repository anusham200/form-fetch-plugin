<?php

namespace Custom\FormFetchPlugin\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class FormData extends AbstractDb
{
    protected function _construct()
    {
        // Define your table and the primary key field
        $this->_init('form_fetch_plugin_data', 'email');  // Change to your table name and primary key field
    }
}
