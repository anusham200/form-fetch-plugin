<?php
namespace Custom\FormFetchPlugin\Block;

use Magento\Backend\Block\Template;

class Form extends Template
{
    protected $_fetchedData = null;

    public function setFetchedData($data)
    {
        $this->_fetchedData = $data;
        return $this; // Return $this for chaining
    }

    public function getFetchedData()
    {
        return $this->_fetchedData;
    }
}
