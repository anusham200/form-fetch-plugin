<?php
namespace Custom\FormFetchPlugin\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\App\RequestInterface;

class Form extends Template
{
    protected $request;
    protected $messageManager;

    public function __construct(
        Template\Context $context,
        RequestInterface $request,
        \Magento\Framework\Message\ManagerInterface $messageManager,
        array $data = []
    ) {
        $this->request = $request;
        $this->messageManager = $messageManager;
        parent::__construct($context, $data);
    }

    public function getFormActionUrl()
    {
        return $this->getUrl('formfetch/actions/index');  // Adjust if necessary
    }

    public function getFormKeyHtml()
    {
        return $this->getLayout()->createBlock('Magento\Framework\View\Element\FormKey')->getFormKeyHtml();
    }

    public function getSuccessMessage()
    {
        // If you want to show success message dynamically in the frontend.
        return $this->messageManager->getMessages()->getLastAddedMessage()->getText();
    }
}
