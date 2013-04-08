
<?php
// ein Kommandozeilen-Filter im Unix-Stil zum Umwandeln von Groß- in
// Kleinschreibung am Beginn eines Abschnitts
$fp = fopen("php://stdin", "r") or die("kann stdin nicht lesen");
while (!feof($fp)) {
  $zeile = fgets($fp);
  $zeile = preg_replace_callback(
    '|<p>\s*\w|',
    create_function(
      // hier sind entweder einfache Anführungszeichen nötig
      // oder alternativ die Maskierung aller $ als \$
      '$treffer',
      'return strtolower($treffer[0]);'
    ),
    $zeile
  );
  echo $zeile;
}
fclose($fp);
?>

