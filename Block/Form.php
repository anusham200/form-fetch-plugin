<?php
namespace Custom\FormFetchPlugin\Block;

use Magento\Framework\View\Element\Template;

class Form extends Template
{
    public function __construct(
        Template\Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);
    }

    public function getWelcomeMessage()
    {
        return "Welcome to Magento!";
    }
}
