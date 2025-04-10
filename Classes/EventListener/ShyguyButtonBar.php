<?php

namespace WapplerSystems\Shyguy\EventListener;

use TYPO3\CMS\Backend\Template\Components\ButtonBar;
use TYPO3\CMS\Backend\Template\Components\Buttons\InputButton;
use TYPO3\CMS\Backend\Template\Components\ModifyButtonBarEvent;
use TYPO3\CMS\Core\Imaging\Icon;
use TYPO3\CMS\Core\Imaging\IconFactory;
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class ShyguyButtonBar
{
    public function __invoke(ModifyButtonBarEvent $event): void
    {
        /** @var PageRenderer $pageRenderer */
        $pageRenderer = GeneralUtility::makeInstance(PageRenderer::class);
        $pageRenderer->loadJavaScriptModule('@wapplersystems/shyguy/Shyguy.js');

        $buttons = $event->getButtons();
        $saveButton = $buttons[ButtonBar::BUTTON_POSITION_LEFT][2][0] ?? null;

        if ($saveButton instanceof InputButton && $saveButton->getName() === '_savedok') {
            $iconFactory = GeneralUtility::makeInstance(IconFactory::class);

            $insertSoftHyphen = $event->getButtonBar()->makeLinkButton()
                ->setHref('#insertSoftHyphen')
                ->setTitle(
                    $GLOBALS['LANG']->sL(
                        'LLL:EXT:shyguy/Resources/Private/Language/locallang.xlf:set_hyphen'
                    )
                )
                ->setIcon($iconFactory->getIcon('insert-soft-hyphen', Icon::SIZE_SMALL))
                ->setShowLabelText(true);

            $insertSuperscript = $event->getButtonBar()->makeLinkButton()
                ->setHref('#insertSuperscript')
                ->setTitle(
                    $GLOBALS['LANG']->sL(
                        'LLL:EXT:shyguy/Resources/Private/Language/locallang.xlf:set_supercript'
                    )
                )
                ->setIcon($iconFactory->getIcon('insert-superscript', Icon::SIZE_SMALL));

            $insertSubscript = $event->getButtonBar()->makeLinkButton()
                ->setHref('#insertSubscript')
                ->setTitle(
                    $GLOBALS['LANG']->sL(
                        'LLL:EXT:shyguy/Resources/Private/Language/locallang.xlf:set_subscript'
                    )
                )
                ->setIcon($iconFactory->getIcon('insert-subscript', Icon::SIZE_SMALL));

            $insertQuotationMarks = $event->getButtonBar()->makeLinkButton()
                ->setHref('#insertQuotationMarks')
                ->setTitle(
                    $GLOBALS['LANG']->sL(
                        'LLL:EXT:shyguy/Resources/Private/Language/locallang.xlf:set_quotation_marks'
                    )
                )
                ->setIcon($iconFactory->getIcon('insert-quotation-marks', Icon::SIZE_SMALL));

            $buttonMap = [
                $insertSoftHyphen,
                $insertSuperscript,
                $insertSubscript,
                $insertQuotationMarks,
            ];

            $pos = max(array_keys($buttons[ButtonBar::BUTTON_POSITION_LEFT]));

            foreach ($buttonMap as $key => $button) {
                $buttons[ButtonBar::BUTTON_POSITION_LEFT][$pos + $key + 1][] = $button;
            }
        }

        $event->setButtons($buttons);
    }
}
