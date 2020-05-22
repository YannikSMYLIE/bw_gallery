<?php
// Plugin
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'BoergenerWebdesign.BwGallery',
    'Show',
    'Bildergalerie'
);

// FlexForms
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']["bwgallery_show"] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    "bwgallery_show",
    'FILE:EXT:bw_gallery/Configuration/FlexForms/Show.xml'
);