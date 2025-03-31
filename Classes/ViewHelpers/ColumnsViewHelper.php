<?php
namespace BoergenerWebdesign\BwGallery\ViewHelpers;

use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

class ColumnsViewHelper extends AbstractViewHelper {
    /**
     * Initialisiert die Argumente.
     */
    public function initializeArguments() : void {
        $this->registerArgument('columns', 'int', 'Die maximale Anzahl an möglichen Spalten.', false, 6);
    }

    /**
     * @return array
     */
    public function render() : array {
        /** @var int $max */
        $max = $this -> arguments["columns"];
        return [
            'xs' => min(1, $max),
            'sm' => min(2, $max),
            'md' => min(3, $max),
            'lg' => min(4, $max),
            'xl' => min(6, $max)
        ];
    }
}