<?php

namespace Custom\FormFetchPlugin\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\Message\ManagerInterface;

class Form extends Template
{
    protected $messageManager;

    public function __construct(
        Template\Context $context,
        ManagerInterface $messageManager,
        array $data = []
    ) {
        $this->messageManager = $messageManager;
        parent::__construct($context, $data);
    }

    public function getFormActionUrl()
    {
        // Return the URL where the form should submit data
        return $this->getUrl('formfetch/form/submit');
    }

    public function getFormKeyHtml()
    {
        return $this->getBlockHtml('formkey'); // Retrieve the form key HTML
    }

    public function getSuccessMessage()
    {
        $messages = $this->messageManager->getMessages(true)->getItems();
        foreach ($messages as $message) {
            if ($message->getType() === 'success') {
                return $message->getText();
            }
        }
        return null;
    }
}
