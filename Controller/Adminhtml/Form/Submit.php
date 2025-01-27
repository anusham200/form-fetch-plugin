<?php
namespace Custom\FormFetchPlugin\Controller\Adminhtml\Form;

use Magento\Backend\App\Action;
use Custom\FormFetchPlugin\Model\FormDataFactory;

class Submit extends Action
{
    protected $formDataFactory;

    public function __construct(
        Action\Context $context,
        FormDataFactory $formDataFactory
    ) {
        $this->formDataFactory = $formDataFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $postData = $this->getRequest()->getPostValue(); // Get POST data from the form submission

        if (!empty($postData)) {
            try {
                // Create a model instance
                $formData = $this->formDataFactory->create();
                
                // Set form data values
                $formData->setEmail($postData['email']);
                $formData->setFirstName($postData['firstname']);
                $formData->setLastName($postData['lastname']);
                $formData->setSchoolName($postData['schoolname']);
                
                // Save data to the database
                $formData->save();

                // Success message
                $this->messageManager->addSuccessMessage(__('Form data has been saved successfully.'));
            } catch (\Exception $e) {
                // Error message
                $this->messageManager->addErrorMessage(__('Unable to save form data. Error: %1', $e->getMessage()));
            }
        } else {
            $this->messageManager->addErrorMessage(__('No form data to save.'));
        }

        return $this->_redirect('formfetch/form/index');
    }
}
