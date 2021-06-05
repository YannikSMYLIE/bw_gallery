<?php
if (!defined('TYPO3_MODE')) {
    die ('Access denied.');
}

// Icon registrieren
$iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
    \TYPO3\CMS\Core\Imaging\IconRegistry::class
);
$iconRegistry->registerIcon(
    "tx-bwgallery-icon",
    \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
    ['source' => 'EXT:bw_gallery/Resources/Public/Icons/Extension.svg']
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig('
mod.wizards.newContentElement.wizardItems.common {
    elements {
        tx_bwgallery {
            iconIdentifier = tx-bwgallery-icon
            title = LLL:EXT:bw_gallery/Resources/Private/Language/Tca.xlf:title
            description = LLL:EXT:bw_gallery/Resources/Private/Language/Tca.xlf:description
            tt_content_defValues {
                CType = tx_bwgallery
            }
        }
    }
    show := addToList(tx_bwgallery)
}');