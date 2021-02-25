<?php


namespace App\CSVParser;


use Illuminate\Http\UploadedFile;

interface CsvParserInterface
{
    /**
     * @param   UploadedFile  $file  uploaded csv file
     *
     * @return array of tasks in desired format
     */
    public function parse(UploadedFile $file);

    public function validateCsv(UploadedFile $header);
}