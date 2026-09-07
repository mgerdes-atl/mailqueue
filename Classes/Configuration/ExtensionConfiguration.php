<?php

declare(strict_types=1);

/*
 * This file is part of the TYPO3 CMS extension "mailqueue".
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

namespace CPSIT\Typo3Mailqueue\Configuration;

use CPSIT\Typo3Mailqueue\Extension;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration as CoreExtensionConfiguration;

/**
 * ExtensionConfiguration
 *
 * @author Elias Häußler <e.haeussler@familie-redlich.de>
 * @license GPL-2.0-or-later
 */
final readonly class ExtensionConfiguration
{
    /**
     * @param positive-int $queueDelayThreshold
     * @param positive-int $itemsPerPage
     */
    public function __construct(
        public int $queueDelayThreshold = 1800,
        public int $itemsPerPage = 20,
    ) {}

    public static function create(CoreExtensionConfiguration $extensionConfiguration): self
    {
        $queueDelayThreshold = 1800;
        $itemsPerPage = 20;

        try {
            $queueDelay = $extensionConfiguration->get(Extension::KEY, 'queue/delayThreshold');
            if (is_numeric($queueDelay) && (int)$queueDelay > 0) {
                $queueDelayThreshold = (int)$queueDelay;
            }
        } catch (\Throwable) {
            try {
                $queueDelay = $extensionConfiguration->get(Extension::KEY, 'queue.delayThreshold');
                if (is_numeric($queueDelay) && (int)$queueDelay > 0) {
                    $queueDelayThreshold = (int)$queueDelay;
                }
            } catch (\Throwable) {
            }
        }

        try {
            $items = $extensionConfiguration->get(Extension::KEY, 'pagination/itemsPerPage');
            if (is_numeric($items) && (int)$items > 0) {
                $itemsPerPage = (int)$items;
            }
        } catch (\Throwable) {
            try {
                $items = $extensionConfiguration->get(Extension::KEY, 'pagination.itemsPerPage');
                if (is_numeric($items) && (int)$items > 0) {
                    $itemsPerPage = (int)$items;
                }
            } catch (\Throwable) {
            }
        }

        return new self(
            $queueDelayThreshold,
            $itemsPerPage,
        );
    }
}
