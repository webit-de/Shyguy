<?php

defined('TYPO3') or die();

call_user_func(
    function ($extKey) {
        /**
         * Add/register icons
         */
        $pngIcons = [
            'insert-soft-hyphen' => 'shy.png',
            'insert-superscript' => 'superscript.png',
            'insert-subscript' => 'subscript.png',
            'insert-quotation-marks' => 'quotes.png',
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

