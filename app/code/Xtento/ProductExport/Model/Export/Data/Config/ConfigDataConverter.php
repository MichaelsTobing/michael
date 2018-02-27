<?php

/**
 * Product:       Xtento_ProductExport (2.5.0)
 * ID:            cb9PRAWlxmJOwg/jsj5X3dDv0+dPZORkauC/n26ZNAU=
 * Packaged:      2018-02-26T09:11:39+00:00
 * Last Modified: 2017-11-28T10:56:19+00:00
 * File:          app/code/Xtento/ProductExport/Model/Export/Data/Config/ConfigDataConverter.php
 * Copyright:     Copyright (c) 2018 XTENTO GmbH & Co. KG <info@xtento.com> / All rights reserved.
 */

namespace Xtento\ProductExport\Model\Export\Data\Config;

class ConfigDataConverter implements \Magento\Framework\Config\ConverterInterface
{
    /**
     * {@inheritdoc}
     */
    public function convert($source)
    {
        $classes = [];
        foreach ($source->getElementsByTagName('export') as $exportClass) {
            $id = $exportClass->getAttribute('id');
            $classes[$id] = [
                'class' => $exportClass->getAttribute('class'),
                'profile_ids' => !empty($exportClass->getAttribute('profile_ids')) ? $exportClass->getAttribute('profile_ids') : false
            ];
        }
        return [
            'classes' => $classes,
        ];
    }
}
