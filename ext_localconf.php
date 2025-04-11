<?php

defined('TYPO3') or die();

call_user_func(
    function ($extKey) {
        /**
         * Add/register icons
         */
        $pngIcons = [
            'insert-soft-hyphen' => 'shy.png',
            'insert-superscript' => 'superscript.svg',
            'insert-subscript' => 'subscript.svg',
            'insert-quotation-marks' => 'quotes.svg',
        ];

        $iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);
        foreach ($pngIcons as $identifier => $path) {
            $iconRegistry->registerIcon(
                $identifier,
                \TYPO3\CMS\Core\Imaging\IconProvider\BitmapIconProvider::class,
                ['source' => 'EXT:' . $extKey . '/Resources/Public/Icons/' . $path ]
            );
        }
    }, 'shyguy'
);

