<?php

namespace Custom\FormFetchPlugin\Controller\Adminhtml\Form;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;  // Use the correct Context here
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Message\ManagerInterface;
use Custom\FormFetchPlugin\Model\FormDataFactory;

class Index extends Action
{
    protected $resultPageFactory;
    protected $formDataFactory;
    protected $messageManager;

    public function __construct(
        Context $context,  // This is the correct backend Context
        PageFactory $resultPageFactory,
        FormDataFactory $formDataFactory,
        ManagerInterface $messageManager
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->formDataFactory = $formDataFactory;
        $this->messageManager = $messageManager;
    }

    public function execute()
    {
        // Handle form submission
        $postData = $this->getRequest()->getPostValue();
        
        if (!empty($postData)) {
            try {
                // Create an instance of the form data model
                $formData = $this->formDataFactory->create();

                // Set form data values
                $formData->setEmail($postData['email']);
                $formData->setFirstName($postData['firstname']);
                $formData->setLastName($postData['lastname']);
                $formData->setSchoolName($postData['schoolname']);

                // Save form data to the database
                $formData->save();  // Ensure that this method correctly saves the data

                // Add a success message
                $this->messageManager->addSuccessMessage(__('Form data has been saved successfully.'));
            } catch (\Exception $e) {
                // Log the error and add an error message
                $this->messageManager->addErrorMessage(__('Unable to save form data.'));
            }
        }

        // Render the form page
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->set(__('Form Fetch Plugin'));

        return $resultPage;
    }
}
