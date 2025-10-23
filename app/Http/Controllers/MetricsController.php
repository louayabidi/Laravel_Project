<?php
namespace App\Http\Controllers;
use Prometheus\CollectorRegistry;
use Prometheus\RenderTextFormat;

class MetricsController extends Controller
{
    public function export()
    {
        $registry = new CollectorRegistry();
        $renderer = new RenderTextFormat();
        $result = $renderer->render($registry->getMetricFamilySamples());
        return response($result, 200)
                 ->header('Content-Type', RenderTextFormat::MIME_TYPE);
    }
}
