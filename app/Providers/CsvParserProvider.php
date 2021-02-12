<?php


namespace App\Providers;


use App\CSVParser\CsvParser;
use App\CSVParser\CsvParserInterface;
use Carbon\Laravel\ServiceProvider;

class CsvParserProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(CsvParserInterface::class, CsvParser::class);
    }

    public function boot()
    {
        $this->register();
    }
}