<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClientController extends Controller
{
    function makePayment(Request $request){
      $input = $request->validate([
            'amount' => ['required', 'numeric', 'min:1'],
            'date' => ['required','date']
        ]);
        auth()->user()->payments()->create($input);
        return redirect()->back()->with('success_message', 'Payment Request Completed');

    }
    function makeWithdraw(Request $request){
    //   $input = $request->validate([
    //         'type'    => ['required'],
    //         'requested_for_name'    => ['required','string'],
    //         'relation'    => ['required','string'],
    //         'latest_payment_receipt_details'    => ['required','string'],
    //         'current_payscale'    => ['required','numeric'],
    //         'requested_amount'    => ['nullable','numeric'],
    //         'total_salary_withdraw'    => ['required','numeric'],
    //         'requested_for_date_of_birth' => ['required','date'],
    //         'disease_details' => ['nullable','string'],
    //         'education_details' => ['nullable','string'],
    //         'old_scholarship_details' => ['nullable','string'],
    //         'education_details_2' => ['nullable'],
    //     ]);
        if($request->type == 1)
        {
            $input = $request->validate([
                'type'    => ['required'],
                'requested_for_name'    => ['required', 'string'],
                'relation'    => ['required', 'string'],
                'latest_payment_receipt_details'    => ['required', 'string'],
                'current_payscale'    => ['required', 'numeric'],
                'requested_amount'    => ['nullable', 'numeric'],
                'total_salary_withdraw'    => ['required', 'numeric'],
                'requested_for_date_of_birth' => ['required', 'date'],
                'disease_details' => ['nullable', 'string'],
                // 'education_details' => ['nullable', 'string'],
                'old_scholarship_details' => ['nullable', 'string'],
                // 'education_details_2' => ['nullable'],
            ]);
        }
        else{
            $input = $request->validate([
                'type'    => ['required'],
                'requested_for_name'    => ['required', 'string'],
                'relation'    => ['required', 'string'],
                'latest_payment_receipt_details'    => ['required', 'string'],
                'current_payscale'    => ['required', 'numeric'],
                // 'requested_amount'    => ['nullable', 'numeric'],
                'total_salary_withdraw'    => ['required', 'numeric'],
                'requested_for_date_of_birth' => ['required', 'date'],
                // 'disease_details' => ['nullable', 'string'],
                'education_details' => ['nullable', 'string'],
                'old_scholarship_details' => ['nullable', 'string'],
                'education_details_2' => ['nullable'],
            ]);
            $input['education_details_2'] = json_encode($request->education_details_2);
        }

        auth()->user()->withdraws()->create($input);
        return redirect()->back()->with('success_message', 'Payment Request Completed');

    }
    function getLists() {
        $payments = auth()->user()->payments;
        $withdrawRequests = auth()->user()->withdraws;
        return response()->json([
            'payments' => $payments,
            'withdraws' => $withdrawRequests
        ]);
    }
}
