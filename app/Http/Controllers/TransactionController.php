<?php

namespace App\Http\Controllers;

use App\Exports\TransactionsExport;
use App\Models\Transaction;
use DB;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

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
            $data['message'] = 'Product tidak ditemukan!';
            return response()->json($data, 400);
        }

        //create transaction
        $expired_at = date('Y-m-d H:i:s', strtotime('+1 hour', strtotime(date('Y-m-d H:i:s'))));
        $transaction = new Transaction();
        $transaction->user_id = $request['user_id'];
        $transaction->product_id = $request['product_id'];
        $transaction->quantity = $request['quantity'];
        $transaction->amount = $request['quantity'] * $cekProduct->price;
        $transaction->expired_at = $expired_at;
        if (!$transaction->save()) {
            $data['message'] = 'Gagal menyimpan data transaksi!';
            return response()->json($data, 400);
        }
        $data['message'] = 'Transaksi telah tersimpan, silahkan selesaikan pembayaran anda sebelum ' . $expired_at . '!';
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

    public function payTransaction($id)
    {
        //get transaction
        $cekTransaksi = Transaction::find($id);
        if (is_null($cekTransaksi)) {
            $data['message'] = 'Transaksi tidak ditemukan!';
            return response()->json($data, 400);
        }

        switch ($cekTransaksi->status) {
            case 'expired':
                $data['message'] = 'Transaksi expire!';
                $canPay = false;
                break;
            case 'done':
                $data['message'] = 'Transaksi telah selesai!';
                $canPay = false;
                break;
            case 'paid':
                $data['message'] = 'Transaksi sudah dibayar!';
                $canPay = false;
                break;
            case 'process':
                $data['message'] = 'Transaksi sedang  diproses!';
                $canPay = false;
                break;
            default:
                $canPay = true;
                break;
        }

        if (!$canPay) {
            return response()->json($data, 400);
        }

        //cek expired
        $now = date('Y-m-d H:i:s');
        $start = strtotime($now);
        $end = strtotime($cekTransaksi->expired_at);
        $expired = $end - $start;
        if ($expired < 1) {
            $cekTransaksi->status = 'expired';
            $data['message'] = 'Transaksi expire!';
            return response()->json($data, 400);
        }

        $cekTransaksi->status = 'paid';
        if (!$cekTransaksi->save()) {
            $data['message'] = 'Gagal mengubah status transaksi!';
            return response()->json($data, 400);
        }
        $data['message'] = 'Pembayaran berhasil, transaksi dalam antrian!';
        return response()->json($data, 200);
    }

    public function export()
    {
        return Excel::download(new TransactionsExport, 'transactions' . time() . '.xlsx');
    }
}
