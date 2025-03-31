<?php

namespace BoergenerWebdesign\BwGallery\Domain\Model;

use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Resource as Core;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Domain\Model\Category;
use TYPO3\CMS\Extbase\Persistence\Generic\Mapper\DataMapper;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

class File extends Core\File {
    /** @var ObjectStorage  */
    protected ?ObjectStorage $categories = null;

    /**
     * @return string
     */
    public function getCopyright() : string {
        return $this -> getMetaData()["copyright"] ?? "";
    }

    /**
     * @return string
     */
    public function getDescription() : string {
        return $this -> getProperty("title") ?? $this -> getProperty("description") ?? "";
    }

    /**
     * Gets the categories.
     * @return ObjectStorage
     */
    public function getCategories() : ObjectStorage {
        if(!$this -> categories) {
            $this -> readCategories();
        }
        return $this -> categories;
    }

    public function getCategoriesUidsAsString() : string {
        $uids = [];
        /** @var Category $category */
        foreach($this -> getCategories() -> toArray() as $category) {
            $uids[] = $category -> getUid();
        }
        return implode(",", $uids);
    }

    private function readCategories() : void {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getConnectionForTable('sys_category')->createQueryBuilder();
        $result = $queryBuilder
            -> select('category.*')
            -> from('sys_category', 'category')
            -> join(
                'category',
                'sys_category_record_mm',
                'mm',
                $queryBuilder -> expr() -> and(
                    $queryBuilder -> expr() -> eq('category.uid', $queryBuilder->quoteIdentifier('mm.uid_local')),
                    $queryBuilder -> expr() -> eq('mm.tablenames', $queryBuilder->createNamedParameter('sys_file_metadata')),
                    $queryBuilder -> expr() -> eq('mm.fieldname', $queryBuilder->createNamedParameter('categories'))
                )
            )
            -> join(
                'mm',
                'sys_file_metadata',
                'metadata',
                $queryBuilder -> expr() -> eq('metadata.uid', $queryBuilder->quoteIdentifier('mm.uid_foreign')),
            )
            -> where(
                $queryBuilder -> expr() -> eq('metadata.file', $queryBuilder->createNamedParameter($this -> getUid(), \PDO::PARAM_INT))
            )
            -> executeQuery();
        $array = $result -> fetchAllAssociative();

        // Map array to objects
        $dataMapper = GeneralUtility::makeInstance(DataMapper::class);
        $objects = $dataMapper -> map(Category::class, $array);

        // Save into ObjectStorage
        $this -> categories = new ObjectStorage();
        foreach($objects as $object) {
            $this -> categories -> attach($object);
        }
    }
}