<?php

namespace Api\Php\controllers;

abstract class Controller
{
    protected function json($response = [], $statusCode = 502)
    {
        header('Content-Type: application/json', true, $statusCode);
        echo json_encode($response);
        exit;
    }

    protected function exception($exception, $statusCode)
    {
        header('Content-Type: application/json', true, $statusCode);
        echo json_encode(['error' => $exception->getMessage()]);
        exit;
    }
}
