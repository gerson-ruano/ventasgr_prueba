<?php
if (isset($pdf)) {
    $pdf->page_script('
        if ($PAGE_COUNT > 1) {
            $font = $fontMetrics->get_font("Arial, Helvetica, sans-serif", "normal");
            $size = 10;
            $pageText = "Página: " . $PAGE_NUM . " de " . $PAGE_COUNT;
            $y = 15;
            $x = 520;
            $pdf->text($x, $y, $pageText, $font, $size);
        }
    ');
}
?>
