<?php
$content = file_get_contents(__DIR__ . "/DATA/lieu.csv");
$storageDir = __DIR__ . "/public/storage/programs";
@mkdir($storageDir, 0777, true);
preg_match_all("/(?:^|\r?\n)\"(\d+)\",\"/", $content, $matches, PREG_OFFSET_CAPTURE);
$rowsCount = count($matches[0]);
$imageNames = [];
for ($i = 0; $i < $rowsCount; $i++) {
    $id = $matches[1][$i][0];
    $startOffset = $matches[0][$i][1];
    $endOffset = ($i < $rowsCount - 1) ? $matches[0][$i+1][1] : strlen($content);
    $chunk = substr($content, $startOffset, $endOffset - $startOffset);
    $chunk = ltrim($chunk, "\r\n");
    $pos1 = strpos($chunk, "\",\"");
    $pos2 = strpos($chunk, "\",\"", $pos1 + 3);
    $pos3 = strpos($chunk, "\",\"", $pos2 + 3);
    $pos4 = strpos($chunk, "\",\"", $pos3 + 3);
    if ($pos1 === false || $pos2 === false || $pos3 === false || $pos4 === false) continue;
    $imageBinary = substr($chunk, $pos4 + 3);
    $imageBinary = rtrim($imageBinary, "\r\n");
    if (substr($imageBinary, -1) === "\"") {
        $imageBinary = substr($imageBinary, 0, -1);
    }
    if (strlen($imageBinary) > 0) {
        $filename = "program_" . $id . ".jpg";
        file_put_contents($storageDir . "/" . $filename, $imageBinary);
        $imageNames[] = $filename;
    }
}
echo "Extracted: " . implode(", ", $imageNames) . "\n";

