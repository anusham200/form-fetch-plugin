<?php
namespace Custom\FormFetchPlugin\Controller\Adminhtml\Form;

use Magento\Backend\App\Action;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Controller\ResultFactory;
use Custom\FormFetchPlugin\Model\FormDataFactory;

class Submit extends Action
{
    protected $formDataFactory;
    protected $dataPersistor;

    /**
     * Constructor
     */
    public function __construct(
        Action\Context $context,
        FormDataFactory $formDataFactory,
        DataPersistorInterface $dataPersistor
    ) {
        $this->formDataFactory = $formDataFactory;
        $this->dataPersistor = $dataPersistor;
        parent::__construct($context);
    }

    /**
     * Execute method
     */
    public function execute()
    {
        // Retrieve the form data from the request
        $postData = $this->getRequest()->getPostValue();

        // Check if data is not empty
        if (!empty($postData)) {
            try {
                // Validate form data (for example, check if email is valid)
                if (!filter_var($postData['email'], FILTER_VALIDATE_EMAIL)) {
                    throw new \Magento\Framework\Exception\LocalizedException(__('Invalid email address.'));
                }

                // Create a new instance of the model
                $formData = $this->formDataFactory->create();

                // Set the data (ensure keys match the form's input names)
                $formData->setEmail($postData['email']);
                $formData->setFirstName($postData['firstname']);
                $formData->setLastName($postData['lastname']);
                $formData->setSchoolName($postData['schoolname']);

                // Save the data to the database
                $formData->save();

                // Add success message
                $this->messageManager->addSuccessMessage(__('Form data has been saved successfully.'));
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                // Add error message for validation or other issues
                $this->messageManager->addErrorMessage(__('Unable to save form data. Error: %1', $e->getMessage()));
            } catch (\Exception $e) {
                // Catch any other exceptions
                $this->messageManager->addErrorMessage(__('An unexpected error occurred. Please try again later.'));
            }
        } else {
            // Add warning message if form data is empty
            $this->messageManager->addErrorMessage(__('No form data to save.'));
        }

        // Redirect back to the form or another page
        return $this->_redirect('*/*/index'); // You can change this URL as needed
    }
}
