<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

use App\Models\DigitalManagerGuruTransaction;
use App\Models\EduzzTransaction;
use App\Models\DigitalManagerGuruSubscription;
use App\Models\EduzzSubscription;

class DataExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        //
    }
}
