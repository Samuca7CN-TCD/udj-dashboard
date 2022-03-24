<?php

namespace App\Exports;

use App\Models\DigitalManagerGuruTransaction;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class DigitalManagerGuruTransactionsExport implements FromQuery, WithHeadings, ShouldAutoSize
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
            'cod_id',
            'status',
            'dates_canceled_at',
            'dates_confirmed_at',
            'dates_created_at',
            'dates_expires_at',
            'dates_ordered_at',
            'dates_unavailable_until',
            'dates_updated_at',
            'dates_warranty_until',
            'contact_id',
            'contact_name',
            'contact_email',
            'product_id',
            'product_name',
            'product_unit_value',
            'product_total_value',
            'product_type',
            'product_marketplace_name',
            'product_qty',
            'product_producer_marketplace_id',
            'payment_method',
            'payment_marketplace_id',
            'payment_marketplace_name',
            'payment_marketplace_value',
            'payment_total',
            'payment_net',
            'payment_gross',
            'payment_tax_value',
            'payment_tax_rate',
            'payment_refuse_reason',
            'payment_credit_card_brand',
        ];
    }

    public function query()
    {
        return DigitalManagerGuruTransaction::query()
            ->whereDate($this->type, '>=', $this->start)
            ->whereDate($this->type, '<=', $this->end)
            ->orderBy($this->type, 'asc');
    }
}
