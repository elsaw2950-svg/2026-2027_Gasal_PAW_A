<?php
$weight = array("Andy"=>"70", "Barry"=>"65", "Charlie"=>"75");

echo 'weight = (';

$jumlah = count($weight);
$i = 0;

foreach ($weight as $nama => $berat) {
    echo '"' . $nama . '"=>"' . $berat . '"';

    if ($i < $jumlah - 1) {
        echo ', ';
    }
    $i++;
}

echo ')<br>';

$values = array_values($weight);

echo "Data kedua: " . $values[1];
?>
