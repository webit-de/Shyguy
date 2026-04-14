<?php

namespace WapplerSystems\Shyguy\EventListener;

use TYPO3\CMS\Backend\Template\Components\ButtonBar;
use TYPO3\CMS\Backend\Template\Components\Buttons\InputButton;
use TYPO3\CMS\Backend\Template\Components\ModifyButtonBarEvent;
use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Core\Imaging\IconFactory;
use TYPO3\CMS\Core\Imaging\IconSize;
use TYPO3\CMS\Core\Localization\LanguageService;
use TYPO3\CMS\Core\Page\PageRenderer;

#[AsEventListener(
    identifier: 'shyguy/button-bar'
)]
class ShyguyButtonBar
{
    public function __construct(
        protected readonly IconFactory $iconFactory,
        protected readonly PageRenderer $pageRenderer,
    ) {}

    public function __invoke(ModifyButtonBarEvent $event): void
    {
        $this->pageRenderer->loadJavaScriptModule('@wapplersystems/shyguy/Shyguy.js');

        $buttons = $event->getButtons();
        $saveButton = $buttons[ButtonBar::BUTTON_POSITION_LEFT][2][0] ?? null;

        if ($saveButton instanceof InputButton && $saveButton->getName() === '_savedok') {
            $lang = $this->getLanguageService();
            $buttonBar = $event->getButtonBar();

            $insertSoftHyphen = $buttonBar->makeLinkButton()
                ->setHref('#insertSoftHyphen')
                ->setTitle($lang->sL('LLL:EXT:shyguy/Resources/Private/Language/locallang.xlf:set_hyphen'))
                ->setIcon($this->iconFactory->getIcon('actions-soft-hyphen', IconSize::SMALL))
                ->setShowLabelText(true);

            $insertSuperscript = $buttonBar->makeLinkButton()
                ->setHref('#insertSuperscript')
                ->setTitle($lang->sL('LLL:EXT:shyguy/Resources/Private/Language/locallang.xlf:set_supercript'))
                ->setIcon($this->iconFactory->getIcon('insert-superscript', IconSize::SMALL))
                ->setShowLabelText(true);

            $insertSubscript = $buttonBar->makeLinkButton()
                ->setHref('#insertSubscript')
                ->setTitle($lang->sL('LLL:EXT:shyguy/Resources/Private/Language/locallang.xlf:set_subscript'))
                ->setIcon($this->iconFactory->getIcon('insert-subscript', IconSize::SMALL))
                ->setShowLabelText(true);

            $insertQuotationMarks = $buttonBar->makeLinkButton()
                ->setHref('#insertQuotationMarks')
                ->setTitle($lang->sL('LLL:EXT:shyguy/Resources/Private/Language/locallang.xlf:set_quotation_marks'))
                ->setIcon($this->iconFactory->getIcon('insert-quotation-marks', IconSize::SMALL))
                ->setShowLabelText(true);

            $buttonMap = [
                $insertSoftHyphen,
                $insertSuperscript,
                $insertSubscript,
                $insertQuotationMarks,
            ];

            foreach ($buttonMap as $button) {
                $icon = $button->getIcon();
                if ($icon !== null) {
                    $icon->setMarkup($icon->getMarkup('inline'));
                }
            }

            $pos = max(array_keys($buttons[ButtonBar::BUTTON_POSITION_LEFT]));

            foreach ($buttonMap as $key => $button) {
                $buttons[ButtonBar::BUTTON_POSITION_LEFT][$pos + $key + 1][] = $button;
            }
        }

        $event->setButtons($buttons);
    }

    protected function getLanguageService(): LanguageService
    {
        return $GLOBALS['LANG'];
    }
}
