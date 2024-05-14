<?php

namespace App\Http\Controllers;

use App\Models\PaymentRequest;
use App\Models\WithdrawRequest;
use App\Models\District;
use App\Models\SubDistrict;
use App\Models\User;
use Illuminate\Http\Request;
use PDF;
use DB;

class ReportController extends Controller
{
    public function getSubdistricts($districtId)
    {
        $subdistricts = SubDistrict::where('district_id', $districtId)->get();

        return response()->json($subdistricts);
    }

    public function getReport(Request $request)
    {
        $reportPageName = "";
        $districtName = "ALL";
        $subDistrictName = "ALL";
        $reportsNameList = [
            1 => 'Members Report',
            2 => 'Subscription Payment Report',
            3 => 'Grant Report',
        ];



        if (isset($request->district)) {
            $districtObject = District::find($request->district);
            $districtName = $districtObject->e_name;
        }
        if (isset($request->subdistrict)) {
            $subDistrictObject = SubDistrict::find($request->subdistrict);
            $subDistrictName = $subDistrictObject->e_name;
        }
        $users = new User();
        if ($request->reporttype == 1) {
            $reportPageName = "members_report";
            if (isset($request->subdistrict)) {
                $users = User::where('sub_district_id', $request->subdistrict)->get();
            } else if (isset($request->district)) {
                $districtId = $request->district;
                $users = User::whereHas('subDistrict', function ($query) use ($districtId) {
                    $query->where('district_id', $districtId);
                })->get();
            } else {
                $users = User::get();
            }
        } else if ($request->reporttype == 2) {
            $reportPageName = "payment_report";
            if (isset($request->subdistrict)) {
                $users = User::with(['payments' => function ($query) {
                    $query->where('status', 1);
                }])->where('sub_district_id', $request->subdistrict)->get();
            } else if (isset($request->district)) {
                $districtId = $request->district;
                $users = User::whereHas('subDistrict', function ($query) use ($districtId) {
                    $query->where('district_id', $districtId);
                })->with(['payments' => function ($query) {
                    $query->where('status', 1);
                }])->get();
            } else {
                $users = User::with(['payments' => function ($query) {
                    $query->where('status', 1);
                }])->get();
            }
        } else if ($request->reporttype == 3) {
            $reportPageName = "disbursement_report";

            if (isset($request->subdistrict)) {
                $subDistrictId = $request->subdistrict;
                $users =  WithdrawRequest::whereHas('user', function ($query) use ($subDistrictId) {
                    $query->where('sub_district_id', $subDistrictId);
                })->with('user')->get();
            } else if (isset($request->district)) {
                $districtId = $request->district;

                $users =  WithdrawRequest::whereHas('user.subDistrict', function ($query) use ($districtId) {
                    $query->where('district_id', $districtId);
                })->with('user')->get();
            } else {
                $users =  WithdrawRequest::with('user')->get();
            }
        }

        $reportTitle = $reportsNameList[$request->reporttype];
        $reportFilteredBy = "District: " . $districtName . ", Upazila: " . $subDistrictName;
        return $pdf = PDF::loadView(
            $reportPageName,
            [
                'reportTitle' => $reportTitle,
                'reportFilteredBy' => $reportFilteredBy,
                'districtName' => $districtName,
                'subDistrictName' => $subDistrictName,
                'users' => $users,
            ],
            [],
            [
                'mode' => '',
                'format'               => 'A4',
                'default_font_size'    => '12',
                'default_font'         => 'nikosh',
                'margin_left'          => 10,
                'margin_right'         => 10,
                'margin_top'           => 15,
                'margin_bottom'        => 5,
                'margin_header'        => -10,
                'margin_footer'        => 0,
                'orientation'          => 'L',
                'title'                => 'Teachers Wellfare Trust ',
                'show_watermark'       => false,
                'watermark_font'       => 'sans-serif',
                'display_mode'         => 'fullpage'
            ]
        )->stream('report.pdf');
    }
}
