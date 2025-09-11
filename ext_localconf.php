<?php

defined('TYPO3') or die();

call_user_func(
    function ($extKey) {
        /**
         * Add/register icons
         */
        $extensionSpritePath = 'EXT:' . $extKey . '/Resources/Public/Icons/sprite.svg#';
        $extensionSourcePath = 'EXT:' . $extKey . '/Resources/Public/Icons/';
        $svgIcons = [
            'actions-soft-hyphen' =>
                [
                    'sprite' => 'EXT:core/Resources/Public/Icons/T3Icons/sprites/actions.svg#',
                    'source' => 'EXT:core/Resources/Public/Icons/T3Icons/svgs/actions/'
                ],
            'insert-superscript' =>
                [
                    'sprite' => $extensionSpritePath,
                    'source' => $extensionSourcePath
                ],
            'insert-subscript' =>
                [
                    'sprite' => $extensionSpritePath,
                    'source' => $extensionSourcePath
                ],
            'insert-quotation-marks' =>
                [
                    'sprite' => $extensionSpritePath,
                    'source' => $extensionSourcePath
                ],
        ];

        $iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);


        foreach ($svgIcons as $identifier => $paths) {
            $iconRegistry->registerIcon(
                $identifier,
                \TYPO3\CMS\Core\Imaging\IconProvider\SvgSpriteIconProvider::class,
                [
                    'sprite' =>  $paths['sprite'] . $identifier,
                    'source' =>  $paths['source'] . $identifier . '.svg'
                ]
            );
        }
    }, 'shyguy'
);

