<?php


namespace App\CSVParser;


use Illuminate\Http\UploadedFile;
use Throwable;


class CsvParser implements CsvParserInterface
{
    private $csvData;
    private $tasks;
    private $csvFormat
        = [
            'Functionality',
            'Module',
            'Sub module',
            'Description',
            'PERT time'
        ];

    public function parse(UploadedFile $file)
    {
        try {
            $this->loadFile($file);
            $lastFunctionality = null;
            $lastModule        = null;

            foreach ($this->csvData as $csvTask) {
                if (!$this->hasMoreTasks($csvTask)) {
                    break;
                }

                if (!empty($csvTask['Functionality'])) {
                    $lastFunctionality = $csvTask['Functionality'];
                }

                if (!empty($csvTask['Module'])) {
                    $lastModule = $csvTask['Module'];
                }

                $this->setNewTask($lastFunctionality, $lastModule,
                    $csvTask);
            }

            return $this->tasks;
        } catch (throwable $e) {
            return false;
        }
    }

    private function loadFile(UploadedFile $file)
    {
        $this->csvData = [];
        $i             = 0;
        if ($handle = @fopen($file, "r")) {
            while (($row = fgetcsv($handle, 4096)) !== false) {
                if (empty($header)) {
                    $header = $row;
                    continue;
                }

                foreach ($row as $key => $value) {
                    $this->csvData[$i][$header[$key]] = $value;
                }
                $i++;
            }

            if (!feof($handle)) {
                echo "Error: unexpected fgets() fail\n";
            }

            fclose($handle);
        }
    }

    private function hasMoreTasks(array $csvTask)
    {
        if (empty($csvTask['Functionality'])
            && empty($csvTask['Module'])
            && empty($csvTask['Sub module'])) {
            return false;
        }

        return true;
    }

    private function setNewTask(
        ?string $lastFunctionality,
        ?string $lastModule,
        array $csvTask
    ) {
        $taskTitle = implode('::',
            array_filter([
                $lastFunctionality,
                $lastModule,
                $csvTask['Sub module']
            ]));

        $this->tasks[] = [
            'title'       => $taskTitle,
            'description' => $csvTask['Description'],
            'time'        => $csvTask['PERT time'] * 60
        ];
    }

    public function validateCsv(UploadedFile $file)
    {
        if ($handle = @fopen($file, "r")) {
            $row = fgetcsv($handle, 4096);

            foreach ($this->csvFormat as $key) {
                if (!in_array($key, $row)) {
                    return false;
                }
            }
            fclose($handle);
        }

        return true;
    }
}