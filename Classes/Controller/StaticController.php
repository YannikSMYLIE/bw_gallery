<?php
namespace BoergenerWebdesign\BwGallery\Controller;

class StaticController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {
    /**
     * Zeigt Bilder in einer Galerie an.
     */
    public function showAction() : void {
        $filecollections = $this->settings['includeCategories'] ?? [];
        echo "<pre>";
        print_r($filecollections);
    }

    /**
     * Abstrahiert die Dateien von mehreren FileCollections.
     * @param array $filecollections
     * @return array
     */
    private function getFiles(array $filecollections) : array {

    }
}
