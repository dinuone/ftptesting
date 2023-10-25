<?php

namespace App\Imports;

use App\Models\FileData;
use Maatwebsite\Excel\Concerns\ToModel;

class FileImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    public function __construct($fileId)
    {
        $this->fileId = $fileId;
    }

    public function model(array $row)
    {
        return new FileData([
            'file_id'=>$this->fileId,
            'column1'=>$row[0],
            'column2'=>$row[1],
            'column3'=>$row[3],
            'column4'=>$row[5],
            'column5'=>$row[6],
            'column6'=>$row[8],
            'column7'=>$row[10],
            'column8'=>$row[12],
            'column9'=>$row[13],
            'column10'=>$row[14],
            'column11'=>$row[15],
            'column12'=>$row[24],
            'column13'=>$row[25],
            'column14'=>$row[26],
            'column15'=>$row[39],
            'column16'=>$row[40],
            'column17'=>$row[41],
            'column18'=>$row[118],
            'column19'=>$row[119],
        ]);
    }
}
