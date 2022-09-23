<?php

namespace Pantheon\TerminusCarbon\Model;

use Pantheon\Terminus\Models\TerminusModel;

/**
 * Pantheon Region Information.
 */
class Regions extends TerminusModel
{
    /**
     * @var string[][]
     */
    protected array $regions;

    public function __construct()
    {
        $regions = [
            'us-central1' => [
                'id' => 'us-central1',
                'datacenter' => 'us-central1',
                'country' => 'United States',
                'continent' => 'North America',
                'location' => 'Council Bluffs, Iowa',
                'region_code' => 'us',
                'region' => 'United States',
                'coordinates_latitude' => '41.22118',
                'coordinates_longitude' => '-95.86390',
                'environmental_impact_grid_zone' => 'US-CENT-SWPP',
                'environmental_impact_grid_name' => 'Southwest Power Pool (USA)',
                'environmental_impact_grid_map' => 'https://app.electricitymaps.com/zone/US-CENT-SWPP'
            ],
            'northamerica-northeast1' => [
                'id' => 'northamerica-northeast1',
                'datacenter' => 'northamerica-northeast1',
                'country' => 'Canada',
                'continent' => 'North America',
                'location' => 'Montreal, Quebec',
                'region_code' => 'ca',
                'region' => 'Canada',
                'coordinates_latitude' => '45.5088',
                'coordinates_longitude' => '-73.5878',
                'environmental_impact_grid_zone' => 'CA-QC',
                'environmental_impact_grid_name' => 'Quebec (Canada)',
                'environmental_impact_grid_map' => 'https://app.electricitymaps.com/zone/CA-QC'
            ],
            'europe-west4' => [
                'id' => 'europe-west4',
                'datacenter' => 'europe-west4',
                'country' => 'Netherlands',
                'continent' => 'Europe',
                'location' => 'Eemshaven, Groningen',
                'region_code' => 'eu',
                'region' => 'European Union',
                'coordinates_latitude' => '53.2192',
                'coordinates_longitude' => '6.5667',
                'environmental_impact_grid_zone' => 'NL',
                'environmental_impact_grid_name' => 'Netherlands',
                'environmental_impact_grid_map' => 'https://app.electricitymaps.com/zone/NL'
            ],
            'australia-southeast1' => [
                'id' => 'australia-southeast1',
                'datacenter' => 'australia-southeast1',
                'country' => 'Australia',
                'continent' => 'Australia',
                'location' => 'Sydney, New South Wales',
                'region_code' => 'au',
                'region' => 'Australia',
                'coordinates_latitude' => '-33.8678',
                'coordinates_longitude' => '151.2073',
                'environmental_impact_grid_zone' => 'AUS-NSW',
                'environmental_impact_grid_name' => 'New South Wales (Australia)',
                'environmental_impact_grid_map' => 'https://app.electricitymaps.com/zone/AUS-NSW'
            ],
        ];

        // Append GCP data.
        $regions = $this->appendGCPData($regions);
        $this->regions = $regions;
    }

    /**
     * Append GCP Carbon data.
     * @param array $regions
     * @return array
     */
    protected function appendGCPData(array $regions): array
    {
        $gcp_data = json_decode(file_get_contents(__DIR__ . '/../../data/regions.json'), true);
        foreach ($regions as $id => $region) {
            $data = end($gcp_data[$id]['summary']);
            $regions[$id] = array_merge($region, $data);
        }
        return $regions;
    }

    /**
     * Filter regions by region code.
     * @param string $region
     * @return array
     */
    public function filterByRegionCode(string $region): array
    {
        return array_filter($this->getRegions(), function ($regionArr) use ($region) {
            if (stripos($regionArr['region'], $region) !== false) {
                return $regionArr;
            }
        });
    }

    /**
     * Filter regions by datacenter code.
     * @param string $region
     * @return array
     */
    public function filterByRegionId(string $region): array
    {
        return array_filter($this->getRegions(), function ($regionArr) use ($region) {
            if (stripos($regionArr['id'], $region) !== false) {
                return $regionArr;
            }
        });
    }

    public function getRegions(): array
    {
        return $this->regions;
    }
}
