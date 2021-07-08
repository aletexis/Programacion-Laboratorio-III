<?php

$num = rand(20, 60);
$nf = new NumberFormatter("es", NumberFormatter::SPELLOUT);

echo $num . " - " . $nf->format($num);

?>