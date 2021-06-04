<?php
if (!defined('TYPO3_MODE')) {
    die ('Access denied.');
}

call_user_func(
    function($extKey)
    {
        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'BoergenerWebdesign.BwGallery',
            'Show',
            [
                'Static' => 'show'
            ],
            // non-cacheable actions
            []
        );
    },
    $_EXTKEY
);

// Be Preview
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['cms/layout/class.tx_cms_layout.php']['list_type_Info']['bwgallery_show']['bw_gallery'] =
    \BoergenerWebdesign\BwGallery\Hooks\BePreview::class . '->summary';