<?php

namespace Custom\FormFetchPlugin\Controller\Adminhtml\Form;

use Magento\Backend\App\Action;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Message\ManagerInterface;
use Psr\Log\LoggerInterface;
use Custom\FormFetchPlugin\Model\FormDataFactory;

class Submit extends Action
{
    const ADMIN_RESOURCE = 'Custom_FormFetchPlugin::form_submit';

    protected $formDataFactory;
    protected $logger;

    public function __construct(
        Action\Context $context,
        FormDataFactory $formDataFactory,
        LoggerInterface $logger
    ) {
        $this->formDataFactory = $formDataFactory;
        $this->logger = $logger;
        parent::__construct($context);
    }

    public function execute()
    {
        $postData = $this->getRequest()->getPostValue();

        $this->logger->debug('Form data received: ', $postData);

        if (!empty($postData)) {
            try {
                // Validate required fields
                $email = $postData['email'] ?? null;
                $firstname = $postData['firstname'] ?? null;
                $lastname = $postData['lastname'] ?? null;
                $schoolname = $postData['schoolname'] ?? null;

                if (!$email || !$firstname || !$lastname || !$schoolname) {
                    $this->messageManager->addErrorMessage(__('All fields are required.'));
                    return $this->_redirect('formfetch/form/index');
                }

                // Create and save form data
                $formData = $this->formDataFactory->create();
                $formData->setEmail($email);
                $formData->setFirstName($firstname);
                $formData->setLastName($lastname);
                $formData->setSchoolName($schoolname);

                $formData->save();

                $this->messageManager->addSuccessMessage(__('Form data has been saved successfully.'));
            } catch (\Exception $e) {
                $this->logger->error('Error saving form data: ' . $e->getMessage());
                $this->messageManager->addErrorMessage(__('Unable to save form data. Error: %1', $e->getMessage()));
            }
        } else {
            $this->messageManager->addErrorMessage(__('No form data to save.'));
        }

        return $this->_redirect('formfetch/form/index');
    }
}
