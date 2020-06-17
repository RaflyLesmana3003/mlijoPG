<?php

namespace App\Exports;

use App\Model\Withdrawal;
use Maatwebsite\Excel\Concerns\FromCollection;

class WithdrawExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Withdrawal::all();
    }
}
