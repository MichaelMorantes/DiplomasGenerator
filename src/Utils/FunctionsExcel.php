<?php

class FunctionsExcel
{
    public function importcsv($filename, $return_info = [])
    {
        try {
            if (($handle = fopen($filename, "r")) !== FALSE) {
                while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                    $return_info[] = $data;
                }
                fclose($handle);
            }
        } catch (Exception  $e) {
            return $e->getMessage();
        }

        return $return_info;
    }
}
