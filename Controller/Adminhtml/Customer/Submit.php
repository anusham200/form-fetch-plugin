<?php

namespace Custom\FormFetchPlugin\Controller\Adminhtml\Customer;

use Magento\Backend\App\Action;
use Magento\Framework\Controller\Result\RedirectFactory;

class Submit extends Action
{
    protected $resultRedirectFactory;

    public function __construct(
        Action\Context $context,
        RedirectFactory $resultRedirectFactory
    ) {
        $this->resultRedirectFactory = $resultRedirectFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $postData = $this->getRequest()->getPostValue();

        if (!empty($postData)) {
            // Handle form data, e.g., save to the database or log
            $this->messageManager->addSuccessMessage(__('Form submitted successfully.'));
        } else {
            $this->messageManager->addErrorMessage(__('Failed to submit form.'));
        }

        return $this->resultRedirectFactory->create()->setPath('customer/index/index');
    }
}
