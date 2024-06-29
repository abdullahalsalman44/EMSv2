<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewReportRequest;
use App\services\ReportServices;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public $reportServices;
    public function __construct(ReportServices $reportServices) {
       $this->reportServices=$reportServices;
    }

    public function addReport(NewReportRequest $report)
    {
        return $this->reportServices->addReport($report->validated());
    }

    public function showReports()
    {
        return $this->reportServices->showReports();
    }

    public function showReportsNumber()
    {
        return $this->reportServices->numberOfReports();
    }
}
