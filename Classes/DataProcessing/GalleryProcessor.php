<?php

namespace BoergenerWebdesign\BwGallery\DataProcessing;

use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\CMS\Frontend\DataProcessing\FilesProcessor;

class GalleryProcessor extends FilesProcessor {
    /**
     * Process data of a record to resolve File objects to the view
     *
     * @param ContentObjectRenderer $cObj The data of the content element or page
     * @param array $contentObjectConfiguration The configuration of Content Object
     * @param array $processorConfiguration The configuration of this processor
     * @param array $processedData Key/value store of processed data (e.g. to be passed to a Fluid View)
     * @return array the processed data as key/value store
     */
    public function process(ContentObjectRenderer $cObj, array $contentObjectConfiguration, array $processorConfiguration, array $processedData) {
        $processedData = parent::process($cObj, $contentObjectConfiguration, $processorConfiguration, $processedData);

        $limit = isset($cObj->data["tx_bwgallery_limit"]) && $cObj->data["tx_bwgallery_limit"] == 1;
        if($limit) {
            $limitNumber = $cObj->data["tx_bwgallery_limit_number"] ?? 12;
            $targetVariableName = $cObj->stdWrapValue('as', $processorConfiguration, 'files');

            $files = $processedData[$targetVariableName];
            if(count($files) > $limitNumber) {
                $files = array_slice($files, 0, $limitNumber);
                $processedData[$targetVariableName] = $files;
            }
        }

        return $processedData;
    }
}
