<?php

namespace App\Exports;

use App\Models\Transaction;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TransactionsRangeExport implements FromCollection, WithHeadings, WithMapping
{
    protected ?Carbon $from;
    protected ?Carbon $to;
    protected ?int $cashierId;

    public function __construct(?Carbon $from = null, ?Carbon $to = null, ?int $cashierId = null)
    {
        $this->from = $from;
        $this->to = $to;
        $this->cashierId = $cashierId;
    }

    public function collection()
    {
        return Transaction::with(['items.product', 'cashier'])
            ->when($this->cashierId, function ($q) {
                $q->where('cashier_id', $this->cashierId);
            })
            ->when($this->from, function ($q) {
                $q->where('transaction_date', '>=', $this->from);
            })
            ->when($this->to, function ($q) {
                $q->where('transaction_date', '<=', $this->to);
            })
            ->orderBy('transaction_date', 'desc')
            ->get();
    }

    public function map($transaction): array
    {
        $items = $transaction->items->map(function($item) {
            return $item->product ? $item->product->name . ' x' . $item->quantity : '';
        })->implode(', ');

        return [
            $transaction->transaction_number,
            optional($transaction->cashier)->name ?? '-',
            optional($transaction->transaction_date)->toDateTimeString(),
            $items,
            (float) $transaction->subtotal,
            (float) $transaction->discount_amount,
            (float) $transaction->total_amount,
            $transaction->payment_method,
            (float) $transaction->paid_amount,
            (float) $transaction->change_amount,
            $transaction->status,
        ];
    }

    public function headings(): array
    {
        return [
            'Transaction Number',
            'Cashier',
            'Date',
            'Items',
            'Subtotal',
            'Discount',
            'Total',
            'Payment',
            'Paid',
            'Change',
            'Status',
        ];
    }
}
