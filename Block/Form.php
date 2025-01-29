<?php
namespace Custom\FormFetchPlugin\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Message\ManagerInterface;


class Form extends Template
{
    protected $request;
    protected $messageManager;
    protected $_fetchedData = null;

    public function __construct(
        Template\Context $context,
        RequestInterface $request,
        ManagerInterface $messageManager,
        array $data = []
    ) {
        $this->request = $request;
        $this->messageManager = $messageManager;
        parent::__construct($context, $data);
    }

    /**
     * Get URL for form submission
     */
    public function getFormActionUrl()
    {
        return $this->getUrl('formfetch/actions/index');  // Submit form URL
    }

    /**
     * Get URL for fetching details
     */
    public function getFetchUrl()
    {
        return $this->getUrl('formfetch/actions/index'); // Fetch details URL
    }

    /**
     * Get Magento Form Key HTML
     */
    public function getFormKeyHtml()
    {
        return $this->getLayout()->createBlock('Magento\Framework\View\Element\FormKey')->getFormKeyHtml();
    }

    /**
     * Get Success Message
     */
    public function getSuccessMessage()
    {
        $messages = $this->messageManager->getMessages()->getItems();

        foreach ($messages as $message) {
            if ($message->getType() == \Magento\Framework\Message\MessageInterface::TYPE_SUCCESS) {
                return $message->getText();
            }
        }

        return ''; // No success message found
    }

    /**
     * Set fetched data for display
     */
    public function setFetchedData($data)
    {
        $this->_fetchedData = $data;
        return $this; // Return $this for chaining
    }

    /**
     * Get fetched data
     */
    public function getFetchedData()
    {
    return $this->_fetchedData;
    }

}
