<?php
namespace Custom\FormFetchPlugin\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Data\Form\FormKey;

class Formfetch extends Template
{
    protected $_formKey;

    public function __construct(
        Template\Context $context,
        FormKey $formKey,
        array $data = []
    ) {
        $this->_formKey = $formKey;
        parent::__construct($context, $data);
    }

    public function getFormKey()
    {
        return $this->_formKey->getFormKey();
    }

    public function getFormAction()
    {
        return $this->getUrl('formfetch/form/fetch');
    }
}
