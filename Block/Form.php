<?php

namespace Custom\FormFetchPlugin\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\Data\Form\FormKey;

class Form extends Template
{
    protected $formKey;

    public function __construct(
        Template\Context $context,
        FormKey $formKey,
        array $data = []
    ) {
        $this->formKey = $formKey;
        parent::__construct($context, $data);
    }

    /**
     * Get the form key HTML
     *
     * @return string
     */
    public function getFormKeyHtml()
    {
        return '<input type="hidden" name="form_key" value="' . $this->formKey->getFormKey() . '">';
    }

    /**
     * Get the form action URL
     *
     * @return string
     */
    public function getFormActionUrl()
    {
        return $this->getUrl('formfetch/Form/Submit'); // Update the route if necessary
    }
}
