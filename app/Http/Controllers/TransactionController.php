<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class TransactionController extends Controller
{
    public function index()
    {
        return Transaction::orderBy('id', 'desc')->paginate();
    }

    public function store(Request $request)
    {
        $request->validate([
            'qty' => 'required|numeric',
            'price' => 'required|numeric',
            'date' => 'required|date',
            'type' => Rule::in(Transaction::TYPES)
        ]);

        DB::beginTransaction();
        $trx = Transaction::make([
            'description' => $request->type,
            'date' => $request->date,
            'qty' => $request->qty,
            'price' => $request->price,
        ]);

        $lastest = Transaction::orderBy('id', 'desc')->first();
        if ($trx->description == Transaction::PENJUALAN) {
            // check stock 
            if ($lastest != null && $lastest->qty_balance < abs($request->qty)) {
                return response()->json([
                    'message' => 'stok kurang',
                ]);
            }
        }
        $trx->proccess($lastest);

        $trx->save();
        DB::commit();

        return $trx;
    }

    public function update(Request $request, Transaction $trx)
    {
        $request->validate([
            'qty' => 'required|numeric',
            'price' => 'required|numeric',
            'date' => 'required|date',
            'type' => Rule::in(Transaction::TYPES)
        ]);

        DB::beginTransaction();
        $trx->update([
            'description' => $request->type,
            'date' => $request->date,
            'qty' => $request->qty,
            'price' => $request->price,
        ]);

        $lastest = Transaction::where('id', $trx->id - 1)->first();
        $trx->proccess($lastest);

        $trx->save();

        $after = Transaction::where('id', '>', $trx->id)->get();
        if ($after->count() > 0) {
            foreach ($after as $trx) {
                $lastest = Transaction::where('id', $trx->id - 1)->first();
                $trx->proccess($lastest);
            }
        }

        DB::commit();

        return $trx;
    }

    public function destroy(Request $request)
    {
    }
}
