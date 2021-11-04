<?php

namespace App\Exports;

use App\Models\Portfolio;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PortfolioExport implements FromCollection, ShouldAutoSize, WithHeadings, WithMapping
{
    private $id;

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public function collection()
    {
        return Portfolio::findOrFail($this->id)->trades->reverse();
    }

    public function map($trade) :array
    {
        return [
            $trade->instrument,
            ucfirst($trade->status),
            date_to_human($trade->entry_date),
            date_to_human($trade->exit_date),
            $trade->entry_price,
            $trade->exit_price,
            $trade->quantity,
            $trade->take_profit,
            $trade->stop_loss,
            $trade->entry_fee,
            $trade->exit_fee,
            $trade->gain_loss,
            $trade->calculate_percentage,
            $trade->setup,
            $trade->mistake,
            $trade->note,
        ];
    }

    public function headings(): array
    {
        return [
            'Instrument',
            'Status',
            'Entry Date',
            'Exit Date',
            'Entry Price',
            'Exit Price',
            'Quantity',
            'Take Profit',
            'Stop Loss',
            'Entry Fee',
            'Exit Fee',
            'P/L',
            '%',
            'Setup',
            'Mistake',
            'Note'
        ];
    }
}
