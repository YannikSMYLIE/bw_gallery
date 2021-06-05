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
     * @param array $arguments
     * @param \Closure $renderChildrenClosure
     * @param RenderingContextInterface $renderingContext
     * @return string
     */
    public static function renderStatic(array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext): string {
        $currentPage = self::getCurrentPage($arguments["id"]);
        $paginator = new ArrayPaginator($arguments["objects"], $currentPage, $arguments["itemsPerPage"]);

        $output = '';
        $templateVariableContainer = $renderingContext->getVariableProvider();

        $templateVariableContainer->add($arguments['items'], $paginator -> getPaginatedItems());
        $templateVariableContainer->add($arguments['pages'], self::getPages($currentPage, $paginator));
        $output .= $renderChildrenClosure();
        $templateVariableContainer->remove($arguments['pages']);
        $templateVariableContainer->remove($arguments['items']);

        return $output;
    }

    /**
     * Gibt die anzuzeigende Seite zurück.
     * @param int $galleryUid
     * @return int
     */
    private static function getCurrentPage(int $galleryUid) : int {
        $page = 1;

        if(key_exists('tx_bwgallery_gallery', $_GET)) {
            $galleryGetData = $_GET["tx_bwgallery_gallery"];
            if(key_exists('page', $galleryGetData) && key_exists('id', $galleryGetData) && (int)$galleryGetData["id"] === $galleryUid) {
                $page = (int)$galleryGetData["page"];
            }
        }

        return $page ? $page : 1;
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