<?php

namespace Tests\Unit;

use App\CSVParser\CsvParser;
use Illuminate\Http\UploadedFile;
use PHPUnit\Framework\TestCase;

class ParseCsvTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testCsvParse()
    {
        $file   = UploadedFile::fake()->create('fakeCsv.csv', '1000', 'csv');
        $handle = fopen($file, 'wr');

        $header = [
            'Functionality',
            'Module',
            'Sub module',
            'Description',
            'PERT time'
        ];
        $body= [
            'Functionality name',
            'Module name',
            'Sub module name',
            'Description text',
            '50'
        ];

        $desiredResult []= [
            'title'       => 'Functionality name::Module name::Sub module name',
            'description' => 'Description text',
            'time'        => 50 * 60
        ];

        fputcsv($handle, $header);
        fputcsv($handle, $body);

        $csv = new CsvParser();

        $result = $csv->parse($file);

        $this->assertEquals($desiredResult, $result);
    }

}
