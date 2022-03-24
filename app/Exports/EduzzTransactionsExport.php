<?php

namespace App\Exports;

use App\Models\EduzzTransaction;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class EduzzTransactionsExport implements FromQuery, WithHeadings, ShouldAutoSize
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
            'sale_id',
            'contract_id',
            'date_create',
            'date_payment',
            'date_update',
            'due_date',
            'sale_status',
            'sale_status_name',
            'sale_item_id',
            'sale_item_discount',
            'sale_amount_win',
            'sale_net_gain',
            'sale_total',
            'sale_payment_method',
            'client_id',
            'client_name',
            'client_email',
            'content_id',
            'content_title',
        ];
    }

    public function query()
    {
        return EduzzTransaction::query()
            ->whereDate($this->type, '>=', $this->start)
            ->whereDate($this->type, '<=', $this->end)
            ->orderBy($this->type, 'asc');
    }
}
