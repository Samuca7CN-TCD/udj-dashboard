<?php

namespace App\Exports;

use App\Models\DigitalManagerGuruSubscription;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class DigitalManagerGuruSubscriptionsExport implements FromQuery, WithHeadings, ShouldAutoSize
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
            'subscription_code',
            'contact_id',
            'contact_name',
            'product_id',
            'product_name',
            'charged_times',
            'charged_every_days',
            'started_at',
            'created_at',
            'updated_at',
            'cancelled_at',
            'last_status_at',
            'last_status',
            'payment_method',
            'trial_started_at',
            'trial_finished_at',
        ];
    }

    public function query()
    {
        return DigitalManagerGuruSubscription::query()
            ->whereDate($this->type, '>=', $this->start)
            ->whereDate($this->type, '<=', $this->end)
            ->orderBy($this->type, 'asc');
    }
}
