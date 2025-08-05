<?php

namespace App\Exports;

use App\Models\Transaction;
use App\Models\TransactionItem;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SalesReportExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        // Fetch all transactions with items and products
        return Transaction::with(['items.product', 'cashier'])->latest()->get();
    }

    public function map($transaction): array
    {
        // Each row is a transaction
        $items = $transaction->items->map(function($item) {
            return $item->product ? $item->product->name . ' x' . $item->quantity : '';
        })->implode(', ');
        return [
            $transaction->transaction_number,
            $transaction->cashier ? $transaction->cashier->name : '-',
            $transaction->transaction_date,
            $items,
            $transaction->subtotal,
            $transaction->discount_amount,
            $transaction->total_amount,
            $transaction->payment_method,
            $transaction->paid_amount,
            $transaction->change_amount,
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
