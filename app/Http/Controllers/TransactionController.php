<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use DB;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function checkout(Request $request)
    {
        //validation
        request()->validate([
            'user_id' => 'required|numeric',
            'product_id' => 'required|numeric',
            'quantity' => 'required|numeric',
        ]);

        //cek user
        $cekUser = DB::table('users')->where('id', $request['user_id'])->first();
        if (is_null($cekUser)) {
            $data['message'] = 'User tidak ditemukan!';
            return response()->json($data, 400);
        }

        //cek product
        $cekProduct = DB::table('products')->where('id', $request['product_id'])->first();
        if (is_null($cekProduct)) {
            $data['message'] = 'product tidak ditemukan!';
            return response()->json($data, 400);
        }

        //create transaction
        $transaction = new Transaction();
        $transaction->user_id = $request['user_id'];
        $transaction->product_id = $request['product_id'];
        $transaction->quantity = $request['quantity'];
        $transaction->amount = $request['quantity'] * $cekProduct->price;
        if (!$transaction->save()) {
            $data['message'] = 'gagal menyimpan data transaksi!';
            return response()->json($data, 400);
        }
        $data['message'] = 'transaksi telah tersimpan, silahkan selesaikan pembayaran anda!';
        return response()->json($data, 200);
    }

    public function getHistory($user_id)
    {
        //cek user
        $cekUser = DB::table('users')->where('id', $user_id)->first();
        if (is_null($cekUser)) {
            $data['message'] = 'User tidak ditemukan!';
            return response()->json($data, 400);
        }

        $histories = Transaction::with('product')->where('user_id', $user_id)->get();
        $data['data'] = $histories;
        return response()->json($data, 200);
    }
}