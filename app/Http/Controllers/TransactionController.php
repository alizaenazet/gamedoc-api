<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'group_id' => ['required'],
            'total' => ['required'],
            'group_name' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                "message" => "invalid request"
            ],400);
        }

        $user = $request->user();

        $userTransaction = $user->transactions()->where('group_id',$request['group_id'])->first();
        
        if ( empty($userTransaction) == false &&  $userTransaction->status == 'pending') {      
                return response()->json([
                    "id" => $userTransaction->id,
                    "redirect_url" => 'https://app.sandbox.midtrans.com/snap/v3/redirection/'.$userTransaction->token
                ],200);
        }

        $newTransactionId = fake()->uuid();
        $res = Http::withBasicAuth(env('MIDTRANS_SERVER_KEY'),'')->post('https://app.sandbox.midtrans.com/snap/v1/transactions',[
            "transaction_details" => [
                "order_id" => $newTransactionId,
                "gross_amount" => $request['total']
            ],
            "credit_card" => [
                "secure" => true
            ],
            "item_details" => [
                [
                    "price" => $request['total'],
                    "quantity" => 1,
                    "name" => $request['group_name']
                ]
            ],
            "page_expiry" => [
                "duration" => 1,
                "unit" => "hours"
            ]
        ]);

        if ($res->status() >= 400) {
            return response()->json([
                'message' => "something wrong, try again"
            ],500);
        }

        $newTransactionData = $res->collect();
        Transaction::create([
            'id' => $newTransactionId,
            'gamer_name' => $user['name'],
            'group_name' => $request['group_name'],
            'status' => 'pending',
            'gamer_id' => $user->id,
            'group_id' => $request['group_id'],
            'token' => $newTransactionData['token']
        ]);

        
        return response()->json([
            'id' => $newTransactionId,
            'redirect_url' => $newTransactionData['redirect_url']
        ]);

    }

    public function notifHandler(Request $request) {
        $validator = Validator::make($request->all(), [
            'order_id' => 'required',
            'transaction_status' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->noContent(400);
        }

        $isMatchVerifySignature = hash('sha512',($request['order_id'].$request['status_code'].$request['gross_amount'].env('MIDTRANS_SERVER_KEY'))) == $request['signature_key'];
        if ($isMatchVerifySignature == false) {
            return response()->noContent(401);
        }

        $update = Transaction::where('id',$request['order_id'])
            ->update(['status' => $request['transaction_status']]);

        if ($update < 1) {
            return response()->noContent(404);
        }

        return response()->noContent(200);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request,string $groupId)
    {
        $user = $request->user();
        $transaction = Transaction::where('group_id',$groupId)
                        ->where('gamer_id',$user->id)
                        ->first();

        if (empty($transaction)) {
            return response()->noContent(404);
        }

        return response()->json([
            "id" => $transaction->id,
            'gamer_name' => $transaction->gamer_name,
            "group_name" => $transaction->group_name,
            "status" => $transaction->status,
            "redirect_url" => "https://app.sandbox.midtrans.com/snap/v3/redirection/".$transaction->token
        ],200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        //
    }
}
