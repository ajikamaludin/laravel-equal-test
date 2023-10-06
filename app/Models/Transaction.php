<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    const PEMBELIAN = 'Pembelian';
    const PENJUALAN = 'Penjualan';

    const TYPES = [
        self::PEMBELIAN,
        self::PENJUALAN,
    ];

    protected $fillable = [
        'description',
        'date',
        'qty',
        'cost',
        'price',
        'total_cost',
        'qty_balance',
        'value_balance',
        'hpp',
    ];

    public function proccess($lastest)
    {
        if ($lastest == null) {
            $this->cost = $this->price;
            $this->total_cost = $this->qty * $this->cost;
            $this->qty_balance = $this->qty;
            $this->value_balance = $this->total_cost;
            $this->hpp = $this->cost;
        } else {
            if ($this->description == Transaction::PENJUALAN) {
                $this->cost = $lastest->hpp;
                $this->total_cost = $this->qty * $this->cost;
                $this->qty_balance = $lastest->qty_balance + $this->qty;
                $this->value_balance = $lastest->value_balance + $this->total_cost;
                $this->hpp = $lastest->hpp;
            }

            if ($this->description == Transaction::PEMBELIAN) {
                $this->cost = $this->price;
                $this->total_cost = $this->qty * $this->cost;
                $this->qty_balance = $lastest->qty_balance + $this->qty;
                $this->value_balance = $lastest->value_balance + $this->total_cost;
                $this->hpp = $this->value_balance / $this->qty_balance;
            }
        }
    }
}
