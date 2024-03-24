<?php
class FileController {
    public function appendToFile($filePath, $data) {
        // Logic to append data to a file
        $file = fopen($filePath, "a");
        fwrite($file, $data . "\n");
        fclose($file);
    }

    public function readFromFile($filePath) {
        // Logic to read data from a file
        $contents = [];
        $file = fopen($filePath, "r");
        while (!feof($file)) {
            $line = fgets($file);
            if (!empty($line)) {
                $contents[] = $line;
            }
        }
        fclose($file);
        return $contents;
    }
}
?>
