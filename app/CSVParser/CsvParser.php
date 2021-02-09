<?php


namespace App\CSVParser;


use Illuminate\Http\UploadedFile;

class CsvParser implements CsvParserInterface
{
    private array $csv_data;
    private array $tasks;

    public function __construct(string $fileRealPath)
    {
        $this->csv_data = array_slice(
            array_map('str_getcsv',
                file($fileRealPath)),
            1);
    }

    public function parse()
    {
        $lastFunctionality = null;
        $lastModule        = null;

        foreach ($this->csv_data as $csvTask) {
            if (empty($csvTask[0])
                && empty($csvTask[1])
                && empty($csvTask[2])) {
                break;
            }

            if (!empty($csvTask[0])) {
                $lastFunctionality = $csvTask[0];
            }

            if (!empty($csvTask[1])) {
                $lastModule = $csvTask[1];
            }

            $this->setNewTask($lastFunctionality, $lastModule,
                $csvTask);
        }

        return $this->tasks;
    }

    private function setNewTask(
        ?string $lastFunctionality,
        ?string $lastModule,
        array $csvTask
    ) {
        $taskTitle = implode('::',
            array_filter([
                $lastModule,
                $lastFunctionality,
                $csvTask[2]
            ]));

        $this->tasks[] = [
            'title'       => $taskTitle,
            'description' => $csvTask[3],
            'time'        => $csvTask[7]*60
        ];
    }


    public function validateCsv(UploadedFile $file)
    {
        $header = array_slice(
            array_map('str_getcsv',
                file($file->getRealPath())),
            0, 1)[0];

        if($header[0] == "Functionality"&&
        $header[1] == "Module" &&
        $header[2] == "Sub module" &&
        $header[3] == "Description" &&
        $header[7] == "PERT time"){
            return true;
        }
        return false;
    }
}