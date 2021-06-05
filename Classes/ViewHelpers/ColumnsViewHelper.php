<?php
namespace BoergenerWebdesign\BwGallery\ViewHelpers;

use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

class ColumnsViewHelper extends AbstractViewHelper {
    /**
     * Initialisiert die Argumente.
     */
    public function initializeArguments() : void {
        $this->registerArgument('columns', 'int', 'Die maximale Anzahl an möglichen Spalten.', false, 6);
    }

    /**
     * @param array $arguments
     * @param \Closure $renderChildrenClosure
     * @param RenderingContextInterface $renderingContext
     * @return string
     */
    public static function renderStatic(
        array $arguments,
        \Closure $renderChildrenClosure,
        RenderingContextInterface $renderingContext
    ) : array {
        /** @var int $max */
        $max = $arguments["columns"];
        return [
            'xs' => min(1, $max),
            'sm' => min(2, $max),
            'md' => min(3, $max),
            'lg' => min(4, $max),
            'xl' => min(6, $max)
        ];
    }
}