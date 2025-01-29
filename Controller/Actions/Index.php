<?php

namespace Custom\FormFetchPlugin\Controller\Actions;

use Magento\Framework\App\Action\Action;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Message\ManagerInterface;
use Magento\Framework\App\ResourceConnection;

class Index extends Action
{
    protected $resultPageFactory;
    protected $request;
    protected $messageManager;
    protected $resource;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        PageFactory $resultPageFactory,
        RequestInterface $request,
        ManagerInterface $messageManager,
        ResourceConnection $resource
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->request = $request;
        $this->messageManager = $messageManager;
        $this->resource = $resource;
    }

    public function execute()
    {
        $fetchedData = null; // Initialize fetched data

        if ($this->getRequest()->isPost()) {
            try {
                $params = $this->request->getPostValue();

                if (isset($params['submit'])) {
                    // Handle form submission
                    if (empty($params['email']) || empty($params['firstname']) || empty($params['lastname']) || empty($params['schoolname'])) {
                        throw new \Exception(__('All fields are required.'));
                    }

                    // Save data to database
                    $this->saveToDatabase($params);
                    $this->messageManager->addSuccessMessage(__('Data has been saved successfully.'));
                } elseif (isset($params['fetch'])) {
                    // Handle data fetch
                    if (empty($params['fetch_email'])) {
                        throw new \Exception(__('Email is required to fetch details.'));
                    }

                    // Fetch data from the database
                    $fetchedData = $this->fetchFromDatabase($params['fetch_email']);
                    //var_dump($fetchedData);exit();
                    if (!$fetchedData) {
                        throw new \Exception(__('No data found for the provided email.'));
                    }

                    $this->messageManager->addSuccessMessage(__('Data fetched successfully.'));
                }
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            }
        }

        // Pass fetched data to the result page and block
        $resultPage = $this->resultPageFactory->create();
        $block = $resultPage->getLayout()->getBlock('formfetch_block'); // Ensure block name matches

        if ($block) {
            $block->setFetchedData($fetchedData); // Pass data to the block
        }

        // Set the page title dynamically
        $resultPage->getConfig()->getTitle()->set(__('Frontend Form Fetch Plugin'));

        return $resultPage;
    }

    /**
     * Save data to the database
     */
    private function saveToDatabase($params)
    {
        $connection = $this->resource->getConnection();
        $tableName = $this->resource->getTableName('form_fetch_plugin_data'); // Your table name

        $data = [
            'email'       => $params['email'],
            'first_name'  => $params['firstname'],
            'last_name'   => $params['lastname'],
            'school_name' => $params['schoolname'],
        ];

        // Check if a record already exists
        $existingRecord = $connection->fetchOne(
            "SELECT COUNT(*) FROM $tableName WHERE email = :email",
            ['email' => $params['email']]
        );

        if ($existingRecord) {
            // Update record
            $connection->update($tableName, $data, ['email = ?' => $params['email']]);
        } else {
            // Insert new record
            $connection->insert($tableName, $data);
        }
    }

    /**
     * Fetch data from the database based on email
     */
    public function fetchFromDatabase($email)
    {
        $connection = $this->resource->getConnection();
        $tableName = $this->resource->getTableName('form_fetch_plugin_data'); // Your table name

        // Fetch data
        $query = "SELECT * FROM $tableName WHERE email = :email";
        $fetchedData = $connection->fetchRow($query, ['email' => $email]);

        return $fetchedData ?: null;
    }
}
