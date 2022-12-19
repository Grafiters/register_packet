<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ExportExcel implements FromView
{
    protected $data;
    protected $sum_data;
    protected $view;
    function __construct($data, $sum_data, $view) {
            $this->data = $data;
            $this->sum_data = $sum_data;
            $this->view = $view;
    }
    public function view(): View
    {
        return view($this->view, [
            'data' => $this->data,
            'sum_data' => $this->sum_data
        ]);
    }
}
