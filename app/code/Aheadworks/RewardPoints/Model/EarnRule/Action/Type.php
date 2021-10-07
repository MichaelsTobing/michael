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
namespace Aheadworks\RewardPoints\Model\EarnRule\Action;

/**
 * Class Type
 * @package Aheadworks\RewardPoints\Model\EarnRule\Action
 */
class Type implements TypeInterface
{
    /**
     * @var string
     */
    private $title;

    /**
     * @var ProcessorInterface
     */
    private $processor;

    /**
     * @var string[]
     */
    private $attributeCodes;

    /**
     * @param $title
     * @param ProcessorInterface $processor
     * @param array $attributeCodes
     */
    public function __construct(
        $title,
        ProcessorInterface $processor,
        $attributeCodes = []
    ) {
        $this->title = $title;
        $this->processor = $processor;
        $this->attributeCodes = $attributeCodes;
    }

    /**
     * {@inheritdoc}
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * {@inheritdoc}
     */
    public function getProcessor()
    {
        return $this->processor;
    }

    /**
     * {@inheritdoc}
     */
    public function getAttributeCodes()
    {
        return $this->attributeCodes;
    }
}
