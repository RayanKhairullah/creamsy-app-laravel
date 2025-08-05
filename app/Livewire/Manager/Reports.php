<?php

namespace App\Livewire\Manager;

use Livewire\Component;
use App\Models\Transaction;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SalesReportExport;

class Reports extends Component
{
    public $totalSales = 0;
    public $transactionCount = 0;

    public function mount()
    {
        $this->totalSales = Transaction::sum('total_amount');
        $this->transactionCount = Transaction::count();
    }

    public function exportXlsx()
    {
        return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\SalesReportExport, 'sales_report.xlsx');
    }

    public function render()
    {
        return view('livewire.manager.reports')
        ->layout('components.layouts.manager');
    }
}
