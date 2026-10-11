<?php
$fruits = array("Avocado", "Blueberry", "Cherry");

array_push($fruits, "Durian", "Elderberry", "Fig", "Grape", "Honeydew");

unset($fruits[1]);

echo "Data Blueberry dihapus.<br>";
echo 'fruits = ( "';

$fruits = array_values($fruits);

for ($i = 0; $i < count($fruits); $i++) {
    echo $fruits[$i];

    if ($i < count($fruits) - 1) {
        echo '", "';
    }
}

echo '" )<br>';

echo "Nilai dengan indeks tertinggi: " . $fruits[count($fruits) - 1];
?>
