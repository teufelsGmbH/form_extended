<?php

declare(strict_types=1);

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

namespace WapplerSystems\FormExtended\ViewHelpers;

use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Form\ViewHelpers\Form\UploadedResourceViewHelper;

/**
 * This ViewHelper makes the specified Image object available for its
 * childNodes.
 * In case the form is redisplayed because of validation errors, a previously
 * uploaded image will be correctly used.
 *
 * Scope: frontend
 */
class UploadedResourcesViewHelper extends UploadedResourceViewHelper
{

    /**
     * Return a previously uploaded resource.
     * Return NULL if errors occurred during property mapping for this property.
     *
     * @return FileReference|null
     */
    protected function getUploadedResource()
    {
        if ($this->getMappingResultsForProperty()->hasErrors()) {
            return null;
        }
        $resource = $this->getValueAttribute();
        if ($resource instanceof FileReference) {
            return $resource;
        }

        //keep files on back does not work for multiple files (Array)
        //return null to prevent #1297759968 TYPO3\CMS\Extbase\Property\Exception
        if(is_array($resource)) {
            return null;
        }

        return $this->propertyMapper->convert($resource, FileReference::class);

    }
}
