<?php
namespace BoergenerWebdesign\BwGallery\ViewHelpers;

use BoergenerWebdesign\BwGallery\Domain\Model\File;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

class CategoriesViewHelper extends AbstractViewHelper {
    /**
     * Initialisiert die Argumente.
     */
    public function initializeArguments() : void {
        $this->registerArgument('items', "array", 'Die einzelnen Bilder.', true);
    }

    /**
     * @return ObjectStorage
     */
    public function render() : ObjectStorage {
        $categories = new ObjectStorage();

        /** @var File $image */
        foreach($this -> arguments["items"] as $image) {
            $categories -> addAll($image -> getCategories());
        }

        return $categories;
    }
}