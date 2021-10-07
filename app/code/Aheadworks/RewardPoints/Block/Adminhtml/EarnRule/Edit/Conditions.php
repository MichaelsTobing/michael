<?php
/**
 * Aheadworks Inc.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * https://ecommerce.aheadworks.com/end-user-license-agreement/
 *
 * @package    RewardPoints
 * @version    1.7.2
 * @copyright  Copyright (c) 2020 Aheadworks Inc. (http://www.aheadworks.com)
 * @license    https://ecommerce.aheadworks.com/end-user-license-agreement/
 */
namespace Aheadworks\RewardPoints\Block\Adminhtml\EarnRule\Edit;

use Aheadworks\RewardPoints\Block\Adminhtml\EarnRule\Edit\Conditions\Form;
use Magento\Backend\Block\Widget\Form\Generic;
use Magento\Backend\Block\Template\Context;
use Magento\Framework\Registry;
use Magento\Framework\Data\FormFactory;

/**
 * Class Conditions
 * @package Aheadworks\RewardPoints\Block\Adminhtml\EarnRule\Edit
 * @codeCoverageIgnore
 */
class Conditions extends Generic
{
    /**
     * @var string
     */
    protected $_nameInLayout = 'aw_rp_rule_conditions_block';

    /**
     * @var Form
     */
    private $form;

    /**
     * @param Context $context
     * @param Registry $registry
     * @param FormFactory $formFactory
     * @param Form $form
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        FormFactory $formFactory,
        Form $form,
        array $data = []
    ) {
        $this->form = $form;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * {@inheritdoc}
     */
    protected function _prepareForm()
    {
        $form = $this->createForm();
        $this->form->prepareForm($form);
        $this->setForm($form);
        return parent::_prepareForm();
    }

    /**
     * Create form for controls
     *
     * @return \Magento\Framework\Data\Form
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function createForm()
    {
        $form = $this->_formFactory->create();
        $form->setHtmlIdPrefix($this->form->getFormIdPrefix());

        return $form;
    }
}
