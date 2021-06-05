<?php

// Neue Felder hinzufügen
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('tt_content',
    [
        'tx_bwgallery_pagination' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:bw_gallery/Resources/Private/Language/Tca.xlf:tx_bwgallery_pagination',
            'onChange' => 'reload',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
                'default' => 1,
                'items' => [
                    [
                        0 => '',
                        1 => '',
                    ]
                ],
            ],
        ],
        'tx_bwgallery_pagination_top' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:bw_gallery/Resources/Private/Language/Tca.xlf:tx_bwgallery_pagination_top',
            'displayCond' => [
                'OR' => [
                    'FIELD:tx_bwgallery_pagination:REQ:true',
                    'REC:NEW:true',
                ],
            ],
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
                'default' => 1,
                'items' => [
                    [
                        0 => '',
                        1 => '',
                    ]
                ],
            ],
        ],
        'tx_bwgallery_pagination_bottom' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:bw_gallery/Resources/Private/Language/Tca.xlf:tx_bwgallery_pagination_bottom',
            'displayCond' => [
                'OR' => [
                    'FIELD:tx_bwgallery_pagination:REQ:true',
                    'REC:NEW:true',
                ],
            ],
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
                'default' => 1,
                'items' => [
                    [
                        0 => '',
                        1 => '',
                    ]
                ],
            ],
        ],
        'tx_bwgallery_pagination_elements' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:bw_gallery/Resources/Private/Language/Tca.xlf:tx_bwgallery_pagination_elements',
            'displayCond' => [
                'OR' => [
                    'FIELD:tx_bwgallery_pagination:REQ:true',
                    'REC:NEW:true',
                ],
            ],
            'config' => [
                'type' => 'input',
                'default' => 48,
                'eval' => 'required,int',
                'range' => [
                    'lower' => 1,
                    'upper' => 100
                ]
            ],
        ],
        'tx_bwgallery_columns' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:bw_gallery/Resources/Private/Language/Tca.xlf:tx_bwgallery_columns',
            'config' => [
                'type' => 'input',
                'default' => 6,
                'eval' => 'required,int',
                'range' => [
                    'lower' => 1,
                    'upper' => 6
                ]
            ],
        ],
    ]
);

// Feld einer neuen Palette hinzufügen
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addFieldsToPalette(
    'tt_content',
    'tx_bwgallery_files',
    'file_collections,--linebreak--,image'
);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addFieldsToPalette(
    'tt_content',
    'tx_bwgallery_pagination',
    'tx_bwgallery_pagination, tx_bwgallery_pagination_top, tx_bwgallery_pagination_bottom, tx_bwgallery_pagination_elements'
);


// Eigenes Inhaltselement registrieren
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTcaSelectItem(
    'tt_content',
    'CType',
    [
        'LLL:EXT:bw_gallery/Resources/Private/Language/Tca.xlf:title',
        'tx_bwgallery',
        'tx-bwgallery-icon',
    ],
    'textmedia',
    'after'
);

// Eigenes Inhaltselement definieren
$GLOBALS['TCA']['tt_content']['types']['tx_bwgallery'] = [
    'previewRenderer' => \BoergenerWebdesign\BwGallery\Preview\PreviewRenderer::class,
    'showitem' => '
        --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
            --palette--;;general,
            --palette--;;headers,
        --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.media,
            --palette--;LLL:EXT:bw_gallery/Resources/Private/Language/Tca.xlf:tx_bwgallery_pagination;tx_bwgallery_pagination,
            tx_bwgallery_columns,
            --palette--;Dateien;tx_bwgallery_files,
        --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.appearance,
            --palette--;;frames,
            --palette--;;appearanceLinks,
        --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language,
            --palette--;;language,
        --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access,
            --palette--;;hidden,
            --palette--;;access,
        --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:categories,
            categories,
        --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:notes,
            rowDescription,
        --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:extended,
    
    
        --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
            --palette--;;general,
      ',
];