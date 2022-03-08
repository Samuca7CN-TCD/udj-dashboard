<?php

namespace App\Exports;

use App\Models\EduzzSubscription;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class EduzzSubscriptionsExport implements FromQuery, WithHeadings, ShouldAutoSize
{
    use Exportable;

    public function __construct($type, $start, $end)
    {
        $this->type = $type;
        $this->start = $start;
        $this->end = $end;
        return $this;
    }

    public function headings(): array
    {
        return [
            'id',
            'contract_id',
            'contract_start_date',
            'contract_status',
            'contract_invoice',
            'contract_cancel_date',
            'contract_update_date',
            'contract_cancel_reason',
            'client_id',
            'client_name',
            'client_email',
            'product_id',
            'product_name',
            'payment_value',
            'payment_method',
            'payment_last_date',
            'payment_repeat_type',
        ];
    }

    public function query()
    {
        return EduzzSubscription::query()
            ->whereDate($this->type, '>=', $this->start)
            ->whereDate($this->type, '<=', $this->end)
            ->orderBy($this->type, 'asc');
    }
}
