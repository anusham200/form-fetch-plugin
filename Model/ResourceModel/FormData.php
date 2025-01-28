namespace Custom\FormFetchPlugin\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class FormData extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('form_fetch_plugin_data', 'email'); // table name and primary key
    }
}

