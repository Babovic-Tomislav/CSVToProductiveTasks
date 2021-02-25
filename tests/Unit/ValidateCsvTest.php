<?php

namespace Tests\Unit;


use App\CSVParser\CsvParser;
use Illuminate\Http\UploadedFile;
use PHPUnit\Framework\TestCase;

class ValidateCsvTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testCsvValidation()
    {
        $file = UploadedFile::fake()->create('fakeCsv.csv', '1000', 'csv');
        $handle = fopen($file, 'wr');

        $header = [
            'Functionality',
            'Module',
            'Sub module',
            'Description',
            'PERT time'
        ];

        fputcsv($handle, $header);

        $csv = new CsvParser();

        $result = $csv->validateCsv($file);

        $this->assertTrue($result);
    }
}

