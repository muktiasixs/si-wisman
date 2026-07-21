<?php
$file = 'c:\laragon\www\wisatawan\public\countries.geo.json';
$data = file_get_contents($file);
$j = json_decode($data);

// Add Singapore if not exists
$singaporeExists = false;
foreach($j->features as $f) {
    if (isset($f->properties->name) && stripos($f->properties->name, 'Singa') !== false) {
        $singaporeExists = true;
        break;
    }
}

if (!$singaporeExists) {
    $singaporeFeature = [
        "type" => "Feature",
        "id" => "SGP",
        "properties" => [
            "name" => "Singapore"
        ],
        "geometry" => [
            "type" => "Point",
            "coordinates" => [103.8198, 1.3521]
        ]
    ];
    $j->features[] = $singaporeFeature;
    file_put_contents($file, json_encode($j));
    echo "Added Singapore to GeoJSON.\n";
} else {
    echo "Singapore already exists.\n";
}
