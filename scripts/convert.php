<?php

/**
 * Convert combined region CSV into single JSON.
 */

use ParseCsv\Csv;

require_once __DIR__ . '/../vendor/autoload.php';

$csv = new Csv();
$csv->parseFile(__DIR__ . '/../data/regions.csv');
$output = [];
$count = 0;
foreach ($csv->data as $record) {
    $count++;
    $name = $record['region'];
    if (!isset($output[$name])) {
        $output[$name] = [
            'name' => $name,
            'location' => $record['location'],
            'summary' => [
                [
                    "cfe" => $record['cfe'],
                    "grid_carbon_intensity" => $record['grid_carbon_intensity'],
                    "net_operational_ghg_emissions" => $record['net_operational_ghg_emissions'],
                    "year" => $record['year']
                ]
            ]
        ];
    } else {
        $output[$name]['summary'][] = [
            "cfe" => $record['cfe'],
            "grid_carbon_intensity" => $record['grid_carbon_intensity'],
            "net_operational_ghg_emissions" => $record['net_operational_ghg_emissions'],
            "year" => $record['year']
        ];
    }
}

$regions = json_encode($output, JSON_PRETTY_PRINT);
file_put_contents(__DIR__ . '/../data/regions.json', $regions);
die("Converted $count records." . PHP_EOL);
