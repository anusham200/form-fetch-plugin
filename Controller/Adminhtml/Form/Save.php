<?php
namespace Custom\FormFetchPlugin\Controller\Adminhtml\Form;

use Magento\Backend\App\Action;

class Save extends Action
{
    public function execute()
    {
        $postData = $this->getRequest()->getPostValue();
        if ($postData) {
            // Handle the form submission (e.g., save to the database)
            $this->messageManager->addSuccessMessage('Data saved successfully!');
        } else {
            $this->messageManager->addErrorMessage('Failed to save data.');
        }

        // Redirect back to the form
        return $this->_redirect('*/*/index');
    }
}
