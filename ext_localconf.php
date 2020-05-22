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