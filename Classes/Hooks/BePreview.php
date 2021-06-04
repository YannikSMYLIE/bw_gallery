<?php

namespace BoergenerWebdesign\BwGallery\Hooks;

use BoergenerWebdesign\BwGallery\Utility\FileUtility;
use Fixpunkt\FpFundraisingbox\Domain\Model\Projekt;
use Fixpunkt\FpFundraisingbox\Domain\Repository\ProjektRepository;
use TYPO3\CMS\Core\Service\FlexFormService;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use TYPO3\CMS\Fluid\View\StandaloneView;

class BePreview {
    /** @var FileUtility  */
    protected FileUtility $fileUtility;


    /**
     * Rendert die Backend Vorschau.
     * @param array $params
     * @param object $pObj
     * @return string
     */
    public function summary(array $params, object &$pObj) : string {
        /** @var ObjectManager $objectManager */
        $objectManager = GeneralUtility::makeInstance(ObjectManager::class);
        $this -> fileUtility = $objectManager -> get(FileUtility::class);

        $flexFormData = $this -> readFlexForm($params["row"]["pi_flexform"]);
        $files = $this -> fileUtility -> getFiles($flexFormData["collections"], $flexFormData["files"]);
        return $this -> render($flexFormData, $files);
    }

    /**
     * Liest das FlexForm ein und speichert es.
     * @param string $xml
     * @return array
     */
    private function readFlexForm(string $xml) : array {
        $flexFormService = GeneralUtility::makeInstance(FlexFormService::class);
        $settings = $flexFormService->convertFlexFormContentToArray($xml)["settings"];

        $settings["pagination"]["active"] = isset($settings["pagination"]["active"]) ? (bool)$settings["pagination"]["active"] : true;
        $settings["pagination"]["insertBelow"] = isset($settings["pagination"]["insertBelow"])  ? (bool)$settings["pagination"]["insertBelow"] : true;
        $settings["pagination"]["insertAbove"] = isset($settings["pagination"]["insertAbove"])  ? (bool)$settings["pagination"]["insertAbove"] : true;
        $settings["pagination"]["itemsPerPage"] = (int)$settings["pagination"]["itemsPerPage"] ? (int)$settings["pagination"]["itemsPerPage"] : 36;
        $settings["columns"]  = (int)$settings["columns"] ? (int)$settings["columns"] : 4;
        $settings["collections"] = $settings["collections"] ? explode(",", $settings["collections"]) : [];
        $settings["files"] = $settings["files"] ? explode(",", $settings["files"]) : [];
        return $settings;
    }

    /**
     * Rendert die komplette Darstellung der Box.
     * @param array $flexFormData
     * @param array $files
     * @return string
     */
    protected function render(array $flexFormData, array $files) : string {
        $filePath = GeneralUtility::getFileAbsFileName('EXT:bw_gallery/Resources/Private/Backend/Preview.html');

        /** @var StandaloneView $view */
        $view = GeneralUtility::makeInstance(StandaloneView::class);
        $view->setTemplatePathAndFilename($filePath);

        $variables = [
            'settings' => $flexFormData,
            'files' => $files
        ];
        $view->assignMultiple($variables);
        return $view->render();
    }
}
