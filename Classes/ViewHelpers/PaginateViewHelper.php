<?php
namespace BoergenerWebdesign\BwGallery\ViewHelpers;

use TYPO3\CMS\Core\Pagination\ArrayPaginator;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

class PaginateViewHelper extends AbstractViewHelper {
    /** @var bool */
    protected $escapeOutput = false;

    /**
     * Initialisiert die Argumente.
     */
    public function initializeArguments() : void {
        $this->registerArgument('objects', 'array', 'Die maximale Anzahl an möglichen Spalten.', true);
        $this->registerArgument('items', 'string', 'Die maximale Anzahl an möglichen Spalten.', true);
        $this->registerArgument('pages', 'string', 'Die maximale Anzahl an möglichen Spalten.', true);
        $this->registerArgument('itemsPerPage', 'int', 'Die maximale Anzahl an möglichen Spalten.', false, 48);
        $this->registerArgument('id', 'int', 'Die maximale Anzahl an möglichen Spalten.', true);
    }

    /**
     * @return string
     */
    public function render(): string {
        $currentPage = self::getCurrentPage($this -> arguments["id"]);
        $paginator = new ArrayPaginator($this -> arguments["objects"], $currentPage, $this -> arguments["itemsPerPage"]);

        $output = '';
        $templateVariableContainer = $this -> renderingContext->getVariableProvider();

        $templateVariableContainer->add($this -> arguments['items'], $paginator -> getPaginatedItems());
        $templateVariableContainer->add($this -> arguments['pages'], self::getPages($currentPage, $paginator));
        $output .= $this->renderChildren();
        $templateVariableContainer->remove($this -> arguments['pages']);
        $templateVariableContainer->remove($this -> arguments['items']);

        return $output;
    }

    /**
     * Gibt die anzuzeigende Seite zurück.
     * @param int $galleryUid
     * @return int
     */
    private static function getCurrentPage(int $galleryUid) : int {
        $page = 1;

        if(key_exists('bwGallery', $_GET)) {
            $galleryGetData = $_GET["bwGallery"];
            if(key_exists('page', $galleryGetData) && key_exists('uid', $galleryGetData) && (int)$galleryGetData["uid"] === $galleryUid) {
                $page = (int)$galleryGetData["page"];
            }
        }

        return $page ?: 1;
    }

    /**
     * Gibt ein Array mit den Seiten zurück.
     * @param int $currentPage
     * @param ArrayPaginator $paginator
     * @return array
     */
    private static function getPages(int $currentPage, ArrayPaginator $paginator) : array {
        $pages = [];
        for($i = 1; $i <= $paginator -> getNumberOfPages(); $i++) {
            $pages[$i] = $i === $currentPage;
        }
        return $pages;
    }
}