<?php

namespace Custom\Form\Block;

use Magento\Framework\View\Element\Template;

class Form extends Template
{
    /**
     * Constructor
     *
     * @param Template\Context $context
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);
    }

    /**
     * A sample method to fetch some data for the template
     *
     * @return string
     */
    public function getWelcomeMessage()
    {
        return "Welcome to Magento!";
    }
}
