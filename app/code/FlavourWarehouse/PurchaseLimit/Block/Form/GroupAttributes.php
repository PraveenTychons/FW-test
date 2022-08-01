<?php

namespace FlavourWarehouse\PurchaseLimit\Block\Form;

class GroupAttributes extends \Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray
{
    /**
     * @var \Magento\Framework\Data\Form\Element\Factory
     */
    protected $elementFactory;

    /**
     * @var \Magento\Customer\Model\ResourceModel\Group\CollectionFactory
     */
    protected $collectionFactory;

    /**
     *
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Data\Form\Element\Factory $elementFactory
     * @param \Magento\Customer\Model\ResourceModel\Group\CollectionFactory $collectionFactory
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Data\Form\Element\Factory $elementFactory,
        \Magento\Customer\Model\ResourceModel\Group\CollectionFactory $collectionFactory,
        array $data = []
    ) {
        $this->elementFactory = $elementFactory;
        $this->collectionFactory = $collectionFactory;
        parent::__construct($context, $data);
    }

    /**
     * construct
     */
    protected function _construct()
    {

        $this->addColumn('customer_group', [
            'label' => __('Customer Group'),
            'size' => 35,
        ]);
        $this->addColumn('purchase_limit', [
            'label' => __('Purchase Limit'),
            'size' => 30,
            'class' => 'validate-number validate-digits validate-greater-than-zero'
        ]);
         $this->addColumn('reset_date', [
            'label' => __('Reset Date'),
            'size' => 60,
            'class' => 'validate-date-au'
        ]);

        $this->_addAfter = false;
        $this->_addButtonLabel = __('Add');
        parent::_construct();
    }

    /**
     * @param string $columnName
     * @return mixed|string
     * @throws \Exception
     */
    public function renderCellTemplate($columnName)
    {
        if ($columnName == 'customer_group' && isset($this->_columns[$columnName])) {
            $options  = [['value' => '', 'label'=>__('-- Select Group --')]];

            $group = $this->collectionFactory->create();
            foreach ($group as $eachGroup) {
                $option['value'] = $eachGroup->getCustomerGroupId();
                $option['label'] = $eachGroup->getCustomerGroupCode();
                $options[] = $option;
            }

            $element = $this->elementFactory->create('select');
            $element->setForm(
                $this->getForm()
            )->setName(
                $this->_getCellInputElementName($columnName)
            )->setHtmlId(
                $this->_getCellInputElementId('<%- _id %>', $columnName)
            )->setValues(
                $options
            );

            return str_replace("\n", '', $element->getElementHtml());
        }


        if ($columnName == 'reset_date' && isset($this->_columns[$columnName])) {
            $options  = [['value' => '', 'label'=>__('-- Select Reset Date --')]];


            $durationOptions = array(array("label"=>"3 months", "value"=>"+3 months"), array("label"=>"6 months", "value"=>"+6 months"),
                array("label"=>"1 year", "value"=>"+1 year"),
                array("label"=>"2 year", "value"=>"+2 year")
                );

                
                foreach ($durationOptions as $row) {
                   $option['label'] = $row['label'];
                   $option['value'] = $row['value'];
                   $options[] = $option;
                }
            

            $elements = $this->elementFactory->create('select');
            $elements->setForm(
                $this->getForm()
            )->setName(
                $this->_getCellInputElementName($columnName)
            )->setHtmlId(
                $this->_getCellInputElementId('<%- _id %>', $columnName)
            )->setValues(
                $options
            );

            return str_replace("\n", '', $elements->getElementHtml());
        }

        return parent::renderCellTemplate($columnName);
    }

}