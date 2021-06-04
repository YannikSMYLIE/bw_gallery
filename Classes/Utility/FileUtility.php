<?php
namespace BoergenerWebdesign\BwGallery\Utility;

use TYPO3\CMS\Core\Resource\FileCollectionRepository;

class FileUtility {
    /** @var FileCollectionRepository  */
    protected FileCollectionRepository $fileCollectionRepository;

    /**
     * FileUtility constructor.
     * @param FileCollectionRepository $fileCollectionRepository
     */
    public function __construct(FileCollectionRepository $fileCollectionRepository) {
        $this -> fileCollectionRepository = $fileCollectionRepository;
    }

    /**
     * Gibt die Dateien zurück.
     * @param array $fileCollectionUids
     * @param array $fileUid
     * @return array
     */
    public function getFiles(array $fileCollectionUids, array $fileUid) : array {
        return array_merge(
            $this -> getFilesFromFileCollection($fileCollectionUids),
            $this -> getSingleFiles($fileUid)
        );
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
    private function getSingleFiles(array $fileIds) : array {
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
}