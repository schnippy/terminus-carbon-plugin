<?php

namespace Pantheon\TerminusCarbon\Commands\Carbon;

use Consolidation\OutputFormatters\StructuredData\PropertyList;
use Pantheon\Terminus\Commands\StructuredListTrait;
use Pantheon\TerminusCarbon\Model\Regions;
use Pantheon\Terminus\Commands\Site\SiteCommand;

class SiteRegionCommand extends SiteCommand
{
    use StructuredListTrait;

    /**
     * Displays carbon information about a site.
     *
     * @authorize
     *
     * @command carbon:info
     * @aliases site:carbon:info
     *
     * @field-labels
     *     id: ID
     *     name: Name
     *     label: Label
     *     created: Created
     *     framework: Framework
     *     region: Region
     *     organization: Organization
     *     plan_name: Plan
     *     upstream: Upstream
     *     owner: Owner
     *     datacenter: Datacenter
     *     cfe: Carbon Free Energy % (CFE)
     *     grid_carbon_intensity: Grid Carbon Intensity (gCO2eq/kWh)
     *
     * @return PropertyList
     *
     * @param string $site The name or UUID of a site to retrieve information on
     *
     * @usage <site> Displays <site>'s information with carbon data.
     */
    public function carbonInfo($site)
    {
        $site = $this->sites->get($site);
        $region_id = $site->get('region');
        $region = new Regions();
        $region_data = $region->filterByRegionId($region_id)[$region_id];

        // Define ideal attributes and serialize site data to merge.
        $carbon_attributes = ['cfe', 'grid_carbon_intensity', 'datacenter'];
        $site = $site->serialize();

        // Merge carbon data
        foreach ($region_data as $attr => $value) {
            if (in_array($attr, $carbon_attributes)) {
                $site[$attr] = $value;
            }
        }

        return new PropertyList($site);
    }
}