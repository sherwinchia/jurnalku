<?php

namespace App\Exports;

use App\Models\Portfolio;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PortfolioExport implements FromCollection, ShouldAutoSize, WithHeadings, WithMapping
{
    private $portfolio;

    public function __construct(Portfolio $portfolio)
    {
        $this->portfolio = $portfolio;
    }

    public function collection()
    {
        return $this->portfolio->trades->reverse();
    }

    public function map($trade) :array
    {
        return [
            $trade->instrument,
            ucfirst($trade->status),
            date_to_human($trade->entry_date),
            date_to_human($trade->exit_date),
            decimal_to_human($trade->entry_price, $this->portfolio->currency),
            decimal_to_human($trade->exit_price, $this->portfolio->currency),
            decimal_to_human($trade->quantity),
            decimal_to_human($trade->take_profit, $this->portfolio->currency),
            decimal_to_human($trade->stop_loss, $this->portfolio->currency),
            decimal_to_human($trade->entry_fee, $this->portfolio->currency),
            decimal_to_human($trade->exit_fee, $this->portfolio->currency),
            decimal_to_human($trade->return, $this->portfolio->currency),
            decimal_to_human($trade->calculate_percentage,null,true),
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
            'Return',
            'Return (%)',
            'Setup',
            'Mistake',
            'Note'
        ];
    }
}
