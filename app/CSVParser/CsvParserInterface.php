<?php


namespace App\CSVParser;


use Illuminate\Http\UploadedFile;

interface CsvParserInterface
{
    public function __construct(string $fileRealPath);

    public function parse();

    public function validateCsv(UploadedFile $header);
}