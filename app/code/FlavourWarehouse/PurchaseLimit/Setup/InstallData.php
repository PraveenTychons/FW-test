<?php declare(strict_types=1);

namespace FlavourWarehouse\PurchaseLimit\Setup;

use Magento\Eav\Setup\EavSetup;
use Zend_Validate_Exception;
use Magento\Eav\Model\Config;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Eav\Model\Entity\Attribute\Source\Boolean;
use Magento\Eav\Model\Entity\Attribute\SetFactory as AttributeSetFactory;
use Magento\Customer\Model\Customer;


class InstallData implements InstallDataInterface
{
    /**
     * @var Config
     */
    private $eavConfig;

    /**
     * @var EavSetupFactory
     */
    private $eavSetupFactory;

    /**
     * @var AttributeSetFactory
     */
    private $attributeSetFactory;

    /**
     * AddressAttribute constructor.
     *
     * @param Config              $eavConfig
     * @param EavSetupFactory     $eavSetupFactory
     * @param AttributeSetFactory $attributeSetFactory
     */
    public function __construct(
        Config $eavConfig,
        EavSetupFactory $eavSetupFactory,
        AttributeSetFactory $attributeSetFactory
    ) {
        $this->eavConfig = $eavConfig;
        $this->eavSetupFactory = $eavSetupFactory;
        $this->attributeSetFactory = $attributeSetFactory;
    }

    /**
     * {@inheritdoc}
     */
    public static function getDependencies(): array
    {
        return [];
    }

    /**
     * Create strategic account customer attribute
     * @return void
     * @throws LocalizedException
     * @throws Zend_Validate_Exception
     */
     public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $eavSetup = $this->eavSetupFactory->create();

        $customerEntity = $this->eavConfig->getEntityType('customer');
        $attributeSetId = $customerEntity->getDefaultAttributeSetId();

        $attributeSet = $this->attributeSetFactory->create();
        $attributeGroupId = $attributeSet->getDefaultGroupId($attributeSetId);
        

		/**
		 * Attribute : Purchase limit (purchase_limit)
		 */
        $eavSetup->addAttribute('customer', 'purchase_limit', [
            'type'             => 'decimal',
            'input'            => 'text',
            'label'            => 'Purchase Limit',
            'visible'          => true,
            'required'         => false,
            'user_defined'     => true,
            'system'           => false,
            'global'           => true,
            'visible_on_front' => false,
            'sort_order'       => 250,
            'position'         => 250,
            
        ]);

        $customAttribute = $this->eavConfig->getAttribute('customer', 'purchase_limit');

        $customAttribute->addData([
            'attribute_set_id' => $attributeSetId,
            'attribute_group_id' => $attributeGroupId,
            'used_in_forms' => ['adminhtml_customer', 'customer_account_edit']
        ]);
        $customAttribute->save();

		/**
		 * Balance Limit (balance_limit)
		 */

		$eavSetup->addAttribute('customer', 'balance_limit', [
            'type'             => 'decimal',
            'input'            => 'text',
            'label'            => 'Balance Limit',
            'visible'          => true,
            'required'         => false,
            'user_defined'     => true,
            'system'           => false,
            'global'           => true,
            'visible_on_front' => false,
            'sort_order'       => 255,
            'position'         => 255,
            
        ]);

        $customAttribute = $this->eavConfig->getAttribute('customer', 'balance_limit');

        $customAttribute->addData([
            'attribute_set_id' => $attributeSetId,
            'attribute_group_id' => $attributeGroupId,
            'used_in_forms' => ['adminhtml_customer', 'customer_account_edit']
        ]);
        $customAttribute->save();


		/**
		 * Reset Date  (reset_date)
		 */
		$eavSetup->addAttribute('customer', 'reset_date', [
            'type'             => 'datetime',
            'input'            => 'date',
            'label'            => 'Reset Date',
            'visible'          => true,
            'required'         => false,
            'backend'          => 'Magento\Eav\Model\Entity\Attribute\Backend\Datetime',
            'user_defined'     => true,
            'system'           => false,
            'global'           => true,
            'visible_on_front' => false,
            'sort_order'       => 260,
            'position'         => 260
        ]);

        $customAttribute = $this->eavConfig->getAttribute('customer', 'reset_date');

        $customAttribute->addData([
            'attribute_set_id' => $attributeSetId,
            'attribute_group_id' => $attributeGroupId,
            'used_in_forms' => ['adminhtml_customer', 'customer_account_edit']
        ]);
        $customAttribute->save();

		
    }

    /**
     * {@inheritdoc}
     */
    public function getAliases(): array
    {
        return [];
    }
}