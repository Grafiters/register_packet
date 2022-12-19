<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ExportExcel2 implements FromView
{
    protected $data;

    protected $data2;

    protected $view;
    function __construct($data, $data2, $view) {
            $this->data = $data;

            $this->data2 = $data2;

            $this->view = $view;
    }
    public function view(): View
    {
        return view($this->view, [
            'data' => $this->data,
            'data2' => $this->data2
        ]);
    }
}
