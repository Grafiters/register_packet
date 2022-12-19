<?php

namespace App\Imports;


use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow; //TAMBAHKAN CODE INI

class KaderImport implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public $count = 0;
    public $gagal = 0;
    public $sukses = 0;
    public $jumlah = 0;
    public $hello = "";
    public $ketgagal ="";

    public function collection(Collection $collection)
    {
        foreach($collection as $key=>$row){
            $this->count++;
            $this->hello = $row['No'];
            $this->sukses++; 
        }

        return json_encode($this->sukses);
    }
}
