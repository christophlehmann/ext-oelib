<?php

use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;

/**
 * This ViewHelper creates a Google Map with markers/points on it.
 *
 * In the generated JavaScript, the markers will also be accessible via the map
 * ID and the marker's UID (if the markers implement \Tx_Oelib_Interface_Identity)
 * like this:
 *
 * mapMarkersByUid.tx_oelib_map_1[42]
 *
 * "tx_oelib_map_1" is the map ID which can be retrieved with the function
 * getMapId.
 *
 * 42 is the UID of the corresponding map point.
 *
 * @author Oliver Klee <typo3-coding@oliverklee.de>
 */
class Tx_Oelib_ViewHelpers_GoogleMapsViewHelper extends AbstractViewHelper
{
    /**
     * array key in $GLOBALS['TSFE']->additionalHeaderData for the Google Maps
     * JavaScript library
     *
     * @var string
     */
    const LIBRARY_JAVASCRIPT_HEADER_KEY = 'tx-oelib-googleMapsLibrary';

    /**
     * the prefix to the HTML ID of the generated DIV
     *
     * @var string
     */
    const MAP_HTML_ID_PREFIX = 'tx_oelib_map';

    /**
     * the URL of the Google Maps library
     *
     * @var string
     */
    const GOOGLE_MAPS_LIBRARY_URL = 'https://maps.googleapis.com/maps/api/js?key=';

    /**
     * the default zoom level used when there is exactly one element with
     * coordinates (otherwise the map will automatically be zoomed so that all
     * map points are visible)
     *
     * @var int
     */
    const DEFAULT_ZOOM_LEVEL = 8;

    /**
     * counter of the rendered map instances
     *
     * @var int
     */
    protected static $mapCounter = 0;

    /**
     * current number of the map instance (used for the HTML ID) to make sure
     * that several instances of the ViewHelper on a page will still work
     *
     * @var int
     */
    protected $mapNumber = 0;

    /**
     * Renders a Google Map with $mapPoints on it and sets the corresponding
     * HTML HEAD data.
     *
     * @param \Tx_Oelib_Interface_MapPoint[] $mapPoints
     *        the points to render, may be empty
     * @param string $width
     *        the CSS width of the Map element, e.g., "600px" or "100%",
     *        must be a non-empty valid CSS length
     * @param string $height
     *        the CSS height of the Map element, e.g., "400px" or "60%",
     *        must be a non-empty valid CSS length
     *
     * @return string
     *         HTML for the Google Map, will be empty if there are no map points
     *         with coordinates
     */
    public function render(array $mapPoints = [], $width = '600px', $height = '400px')
    {
        if (!\preg_match('/^\\d+(px|%)$/', $width)) {
            throw new \InvalidArgumentException(
                '$width must be a valid CSS length, but actually is: ' . $width,
                1319058935
            );
        }
        if (!\preg_match('/^\\d+(px|%)$/', $height)) {
            throw new \InvalidArgumentException(
                '$height must be a valid CSS length, but actually is: ' . $height,
                1319058966
            );
        }

        $mapPointsWithCoordinates = $this->findMapPointsWithCoordinates($mapPoints);
        if (empty($mapPointsWithCoordinates)) {
            return '';
        }

        self::$mapCounter++;
        $this->mapNumber = self::$mapCounter;
        $mapId = $this->getMapId();

        $configuration = Tx_Oelib_ConfigurationRegistry::get('plugin.tx_oelib');
        $apiKey = $configuration->getAsString('googleMapsApiKey');

        // pageRenderer->addJsLibrary() would not work here if this ViewHelper
        // is used in an uncached plugin on a cached page.
        $this->getFrontEndController()->additionalHeaderData[self::LIBRARY_JAVASCRIPT_HEADER_KEY]
            = '<script src="' . self::GOOGLE_MAPS_LIBRARY_URL . $apiKey . '" type="text/javascript"></script>';

        $initializeFunctionName = 'initializeGoogleMap_' . $this->mapNumber;
        $this->getFrontEndController()->additionalJavaScript[$mapId]
            = $this->generateJavaScript($mapId, $mapPointsWithCoordinates, $initializeFunctionName);

        // We use the inline JavaScript because adding body onload handlers does not work
        // for uncached plugins on cached pages.
        return '<div id="' . $mapId . '" style="width: ' .
            $width . '; height: ' . $height . ';"></div>' . LF .
            '<script type="text/javascript">' . $initializeFunctionName . '();</script>' . LF;
    }

    /**
     * Generates the JavaScript for the Google Map.
     *
     * @param string $mapId
     *        HTML ID of the map, must not be empty
     * @param \Tx_Oelib_Interface_MapPoint[] $mapPoints
     *        map points with coordinates, must not be empty
     * @param string $initializeFunctionName
     *        name of the JavaScript initialization function to create, must
     *        not be empty
     *
     * @return string the generated JavaScript, will not be empty
     */
    protected function generateJavaScript($mapId, array $mapPoints, $initializeFunctionName)
    {
        // Note: If there are several map points with coordinates and the map
        // is fit to the map points, the Google Maps API still requires a center
        // point. In that case, any point will do (e.g., the first point).
        $centerCoordinates = $mapPoints[0]->getGeoCoordinates();

        return 'var mapMarkersByUid = mapMarkersByUid || {};' . LF .
            'function ' . $initializeFunctionName . '() {' . LF .
            'var center = new google.maps.LatLng(' . \number_format($centerCoordinates['latitude'], 6, '.', '') . ', ' .
            \number_format($centerCoordinates['longitude'], 6, '.', '') . ');' . LF .
            'var mapOptions = {' . LF .
            '  mapTypeId: google.maps.MapTypeId.ROADMAP,' . LF .
            '  scrollwheel: false, ' . LF .
            '  zoom: ' . self::DEFAULT_ZOOM_LEVEL . ', ' . LF .
            '  center: center' . LF .
            '};' . LF .
            'mapMarkersByUid.' . $mapId . ' = {};' . LF .
            'var map = new google.maps.Map(document.getElementById("' . $mapId . '"), mapOptions);' . LF .
            'var bounds = new google.maps.LatLngBounds();' . LF .
            $this->createMapMarkers($mapPoints, $mapId) .
            '}';
    }

    /**
     * Finds the map points within $mapPoints that have coordinates.
     *
     * @param \Tx_Oelib_Interface_MapPoint[] $mapPoints
     *        the points to check for coordinates, may be empty
     *
     * @return \Tx_Oelib_Interface_MapPoint[]
     *         the map points from $mapPoints that have coordinates, might be empty
     */
    protected function findMapPointsWithCoordinates(array $mapPoints)
    {
        $mapPointsWithCoordinates = [];

        foreach ($mapPoints as $mapPoint) {
            if (!($mapPoint instanceof \Tx_Oelib_Interface_MapPoint)) {
                throw new \InvalidArgumentException(
                    'All $mapPoints need to implement \\Tx_Oelib_Interface_MapPoint, but ' .
                    \get_class($mapPoint) . ' does not.',
                    1318093613
                );
            }
            if ($mapPoint->hasGeoCoordinates()) {
                $mapPointsWithCoordinates[] = $mapPoint;
            }
        }

        return $mapPointsWithCoordinates;
    }

    /**
     * Creates the JavaScript code for creating map markers for $mapPoints.
     *
     * @param \Tx_Oelib_Interface_MapPoint[] $mapPoints
     *        the points to render, all must have geo coordinates, may be empty
     * @param string $mapId
     *        HTML ID of the map, must not be empty
     *
     * @return string
     *         the JavaScript code to create all markers, will be empty if
     *         $mapPoints is empty
     */
    protected function createMapMarkers(array $mapPoints, $mapId)
    {
        $javaScript = '';

        foreach ($mapPoints as $index => $mapPoint) {
            $coordinates = $mapPoint->getGeoCoordinates();
            $positionVariableName = 'markerPosition_' . $index;
            $javaScript .= 'var ' . $positionVariableName . ' = new google.maps.LatLng(' .
                \number_format($coordinates['latitude'], 6, '.', '') . ', ' .
                \number_format($coordinates['longitude'], 6, '.', '') . ');' . LF .
                'bounds.extend(' . $positionVariableName . ');';

            $markerParts = [
                'position: ' . $positionVariableName,
                'map: map',
            ];
            $escapedTooltipTitle = \str_replace(
                ['\\', '"', LF, CR],
                ['\\\\', '\\"', '\\n', '\\r'],
                $mapPoint->getTooltipTitle()
            );
            if ($mapPoint->hasTooltipTitle()) {
                $markerParts[] = 'title: "' . $escapedTooltipTitle . '"';
            }

            $markerVariableName = 'marker_' . $index;
            if (($mapPoint instanceof \Tx_Oelib_Interface_Identity) && $mapPoint->hasUid()) {
                $markerParts[] = 'uid: ' . $mapPoint->getUid();
                $mapMarkersByUidEntry = 'mapMarkersByUid.' . $mapId .
                    '[' . $mapPoint->getUid() . '] = ' . $markerVariableName . ';' . LF;
            } else {
                $mapMarkersByUidEntry = '';
            }

            $javaScript .= 'var ' . $markerVariableName . ' = new google.maps.Marker({' . LF .
                '  ' . \implode(',' . LF . '  ', $markerParts) . LF .
                '});' . LF .
                $this->createInfoWindowJavaScript($mapPoint, $markerVariableName, $index) .
                $mapMarkersByUidEntry;
        }

        if (\count($mapPoints) > 1) {
            $javaScript .= 'map.fitBounds(bounds);' . LF;
        }

        return $javaScript;
    }

    /**
     * Creates the JavaScript for the info window of $mapPoint.
     *
     * @param \Tx_Oelib_Interface_MapPoint $mapPoint
     *        the map point for which to create the info window
     * @param string $markerVariableName
     *        valid name of the marker JavaScript variable, must not be empty
     * @param int $index
     *        the zero-based index of the map marker, must be >= 0
     *
     * @return string
     *         JavaScript code for the info window, will be empty if $mapPoint
     *         does not have info window content
     */
    protected function createInfoWindowJavaScript(
        \Tx_Oelib_Interface_MapPoint $mapPoint,
        $markerVariableName,
        $index
    ) {
        if (!$mapPoint->hasInfoWindowContent()) {
            return '';
        }

        $infoWindowVariableName = 'infoWindow_' . $index;
        $escapedInfoWindowContent = str_replace(
            ['\\', '"', LF, CR],
            ['\\\\', '\\"', '\\n', '\\r'],
            $mapPoint->getInfoWindowContent()
        );

        return 'var ' . $infoWindowVariableName . ' = new google.maps.InfoWindow({content: "' .
            $escapedInfoWindowContent . '"});' . LF .
            'google.maps.event.addListener(' . $markerVariableName . ', "click", function() {' . LF .
            '  ' . $infoWindowVariableName . '.open(map, ' . $markerVariableName . ');' . LF .
            '});' . LF;
    }

    /**
     * Returns the ID of the map.
     *
     * The ID is used both for the HTML ID of the DIV HTML element and as the
     * array key in $GLOBALS['TSFE']->additionalHeaderData for the maps-specific
     * Google Maps JavaScript.
     *
     * @return string the map ID, will not be empty
     */
    public function getMapId()
    {
        return self::MAP_HTML_ID_PREFIX . '_' . $this->mapNumber;
    }

    /**
     * Returns $GLOBALS['TSFE'].
     *
     * @return TypoScriptFrontendController
     */
    protected function getFrontEndController()
    {
        return $GLOBALS['TSFE'];
    }
}
