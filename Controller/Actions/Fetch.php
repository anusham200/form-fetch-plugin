<?php
namespace Custom\FormFetchPlugin\Controller\Actions;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\ResultFactory;
use Custom\FormFetchPlugin\Model\Fetch;

class Fetch extends Action
{
    protected $_fetchModel;

    public function __construct(
        Context $context,
        Fetch $fetchModel
    ) {
        $this->_fetchModel = $fetchModel;
        parent::__construct($context);
    }

    public function execute()
    {
        // Check if the form key is valid
        if (!$this->_validateFormKey()) {
            $this->messageManager->addErrorMessage(__('Invalid form submission.'));
            return $this->resultRedirectFactory->create()->setPath('*/*/index');
        }

        // Get email from the request
        $fetchEmail = $this->getRequest()->getPost('fetch_email');

        if ($fetchEmail) {
            // Process the email (for example, save it or fetch details)
            $this->_fetchModel->processFetchEmail($fetchEmail);

            $this->messageManager->addSuccessMessage(__('Fetch details processed successfully.'));
        } else {
            $this->messageManager->addErrorMessage(__('Email is required.'));
        }

        return $this->resultRedirectFactory->create()->setPath('*/*/index');
    }
}
