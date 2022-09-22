<?php

namespace Pantheon\TerminusCarbon\Commands\Carbon;

use Consolidation\OutputFormatters\StructuredData\PropertyList;
use Pantheon\Terminus\Commands\TerminusCommand;
use Pantheon\Terminus\Commands\StructuredListTrait;
use Pantheon\TerminusCarbon\Model\Regions;
use Consolidation\OutputFormatters\StructuredData\RowsOfFields;

/**
 * Say hello to the user
 */
class RegionsCommand extends TerminusCommand
{
    use StructuredListTrait;

    /**
     * Object constructor
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Print region info about the Pantheon regions in Google Cloud.
     *
     * @command carbon:region:list
     * @aliases carbon:regions
     *
     * @filter-output
     *
     * @option string $region Return info about a specific region.
     *
     * @usage --region=<us|ca|eu|au> Displays information about the region.
     *
     * @field-labels
     *     id: ID
     *     country: Country
     *     continent: Continent
     *     location: Location
     *     region: Region
     *     coordinates_latitude: Latitude
     *     coordinates_longitude: Longitude
     *     environmental_impact_grid_zone: Grid Zone
     *     environmental_impact_grid_name: Grid Name
     *     environmental_impact_grid_map: Grid Map
     *     cfe: Carbon Free Energy % (CFE)
     *     grid_carbon_intensity: Grid Carbon Intensity (gCO2eq/kWh)
     *     year: Reporting Year
     *
     * @default-fields id,country,region,grid_carbon_intensity,year
     *
     * @return PropertyList
     *
     */
    public function regionList($options = ['region' => null])
    {
        $regions = new Regions();

        $region_data = $regions->getRegions();
        if (!empty($options['region'])) {
            $region_data = $regions->filterRegion($options['region']);
        }

        $output = new PropertyList($region_data);

        if (!empty($options['format']) && in_array($options['format'], ['table', 'list'])) {
            $output = new RowsOfFields($output);
        }

        return $output;
    }
}
