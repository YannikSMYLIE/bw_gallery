<?php
namespace BoergenerWebdesign\BwGallery\Controller;

class StaticController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {
    /**
     * @var \TYPO3\CMS\Core\Resource\FileCollectionRepository
     * @inject
     */
    protected $fileCollectionRepository = null;

    /**
     * Zeigt Bilder in einer Galerie an.
     */
    public function showAction() : void {
        $filecollectionIds = $this->settings['collections'] ? explode(",", $this->settings['collections']) : [];
        $files = $this -> getFiles($filecollectionIds);
        $this -> view -> assignMultiple([
            "files" => $files
        ]);
    }

    /**
     * Abstrahiert die Dateien von mehreren FileCollections.
     * @param array $filecollectionIds
     * @return array
     */
    private function getFiles(array $filecollectionIds) : array {
        $files = [];

        /** @var int $filecollectionId */
        foreach($filecollectionIds as $filecollectionId) {
            $filecollection = $this -> fileCollectionRepository -> findByUid($filecollectionId);
            $filecollection -> loadContents();
            $filecollection -> rewind();
            while($filecollection -> current()) {
                $files[] = $filecollection -> current();
                $filecollection -> next();
            }
        }

        return $files;
    }
}
