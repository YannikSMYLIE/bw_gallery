<?php
namespace BoergenerWebdesign\BwGallery\Controller;

use TYPO3\CMS\Core\Resource\FileCollectionRepository;
use TYPO3\CMS\Core\Resource\FileRepository;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

class StaticController extends ActionController {
    /** @var FileCollectionRepository */
    protected FileCollectionRepository $fileCollectionRepository;
    /** @var FileRepository */
    protected FileRepository $fileRepository;

    /**
     * StaticController constructor.
     * @param FileCollectionRepository $fileCollectionRepository
     * @param FileRepository $fileRepository
     */
    public function __construct(FileCollectionRepository $fileCollectionRepository, FileRepository $fileRepository) {
        $this -> fileCollectionRepository = $fileCollectionRepository;
        $this -> fileRepository = $fileRepository;
    }

    /**
     * Initialisiert die Darstellung
     */
    public function initializeShowAction() : void {
        $this -> setDefaultValues();
    }

    /**
     * Zeigt Bilder in einer Galerie an.
     */
    public function showAction() : void {
        $files = array_merge(
            $this -> getFilesFromFileCollection($this->settings['collections']),
            $this -> getFiles($this->settings['files'])
        );

        $this -> view -> assignMultiple([
            "files" => $files,
            "guid"=> $this->configurationManager->getContentObject()->data['uid']
        ]);
    }

    /**
     * Abstrahiert die Dateien von mehreren FileCollections.
     * @param array $filecollectionIds
     * @return array
     */
    private function getFilesFromFileCollection(array $filecollectionIds) : array {
        $files = [];

        /** @var int $filecollectionId */
        foreach($filecollectionIds as $filecollectionId) {
            $filecollection = $this -> fileCollectionRepository -> findByUid($filecollectionId);
            $filecollection -> loadContents();


            $filecollection -> rewind();
            while($file = $filecollection -> current()) {
                $file -> _getMetaData();
                $files[] = $file;
                $filecollection -> next();
            }
        }

        return $files;
    }

    /**
     * Erzeugt die Dateien aus gegebenen Ids.
     * @param array $fileIds
     * @return array
     */
    private function getFiles(array $fileIds) : array {
        $resourceFactory = \TYPO3\CMS\Core\Resource\ResourceFactory::getInstance();
        $files = [];

        /** @var int $fileReferenceId */
        foreach($fileIds as $fileReferenceId) {
            $fileReference = \TYPO3\CMS\Backend\Utility\BackendUtility::getRecord('sys_file_reference', $fileReferenceId, "uid_local");
            $fileUid = $fileReference["uid_local"];
            $file = $resourceFactory->getFileObject($fileUid);

            $file -> _getMetaData();
            $files[] = $file;
        }

        return $files;
    }

    /**
     * Setzt die Settings auf Default-Values.
     */
    private function setDefaultValues() : void {
        $this -> settings["pagination"]["active"] = $this -> settings["pagination"]["active"] ? (bool)$this -> settings["pagination"]["active"] : true;
        $this -> settings["pagination"]["insertBelow"] = $this -> settings["pagination"]["insertBelow"]  ? (bool)$this -> settings["pagination"]["insertBelow"] : true;
        $this -> settings["pagination"]["insertAbove"] = $this -> settings["pagination"]["insertAbove"]  ? (bool)$this -> settings["pagination"]["insertAbove"] : true;
        $this -> settings["pagination"]["itemsPerPage"] = (int)36;
        $this -> settings["collections"] = $this -> settings["collections"] ? explode(",", $this -> settings["collections"]) : [];
        $this -> settings["files"] = $this -> settings["files"] ? explode(",", $this -> settings["files"]) : [];
    }
}
