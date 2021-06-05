<?php

namespace BoergenerWebdesign\BwGallery\Preview;

use TYPO3\CMS\Backend\Preview\PreviewRendererInterface;
use TYPO3\CMS\Backend\Preview\StandardContentPreviewRenderer;
use TYPO3\CMS\Backend\View\BackendLayout\Grid\GridColumnItem;
use TYPO3\CMS\Core\Service\FlexFormService;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManager;
use TYPO3\CMS\Fluid\View\StandaloneView;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\CMS\Frontend\DataProcessing\FilesProcessor;

class PreviewRenderer extends StandardContentPreviewRenderer implements PreviewRendererInterface {
    /**
     * Gibt den Header zurück.
     * @param GridColumnItem $item
     * @return string
     */
    public function renderPageModulePreviewHeader(GridColumnItem $item): string {
        return "Fluid Gallery";
    }

    /**
     * Gibt den Body zurück.
     * @param GridColumnItem $item
     * @return string
     * @throws \TYPO3\CMS\Extbase\Object\Exception
     */
    public function renderPageModulePreviewContent(GridColumnItem $item): string {
        $files = $this -> getFiles($item -> getRecord());

        return $this -> render($item -> getRecord(), $files);
    }

    private function getFiles(array $contentObject) : array {
        // Content Object erstellen
        /** @var ContentObjectRenderer $cObject */
        $cObject = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer');
        $cObject -> start($contentObject, 'tt_content');

        // Data Processing Configuration aufrufen
        /** @var ConfigurationManager $configurationManager */
        $configurationManager = GeneralUtility::makeInstance(ConfigurationManager::class);
        $dataProcessorConfiguration = $configurationManager->getConfiguration(
            ConfigurationManager::CONFIGURATION_TYPE_FULL_TYPOSCRIPT
        )['tt_content.']['tx_bwgallery.']['dataProcessing.']['10.'];

        // Dateien einlesen und zurückgeben
        /** @var FilesProcessor $filesProcessor */
        $filesProcessor = GeneralUtility::makeInstance(FilesProcessor::class);
        return $filesProcessor->process(
            $cObject,
            [],
            $dataProcessorConfiguration,
            []
        )["files"];
    }

    /**
     * Rendert die komplette Darstellung der Box.
     * @param array $flexFormData
     * @param array $files
     * @return string
     */
    protected function render(array $data, array $files) : string {
        $filePath = GeneralUtility::getFileAbsFileName('EXT:bw_gallery/Resources/Private/Backend/Preview.html');
        /** @var StandaloneView $view */
        $view = GeneralUtility::makeInstance(StandaloneView::class);
        $view->setTemplatePathAndFilename($filePath);
        $variables = [
            'data' => $data,
            'files' => $files
        ];
        $view->assignMultiple($variables);
        return $view->render();
    }
}