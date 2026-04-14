<?php

declare(strict_types=1);

use TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider;

return [
    'insert-superscript' => [
        'provider' => SvgIconProvider::class,
        'source' => 'EXT:shyguy/Resources/Public/Icons/svgs/superscript.svg',
    ],
    'insert-subscript' => [
        'provider' => SvgIconProvider::class,
        'source' => 'EXT:shyguy/Resources/Public/Icons/svgs/subscript.svg',
    ],
    'insert-quotation-marks' => [
        'provider' => SvgIconProvider::class,
        'source' => 'EXT:shyguy/Resources/Public/Icons/svgs/quotes.svg',
    ],
];
