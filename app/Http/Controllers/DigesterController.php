<?php

namespace App\Http\Controllers;

use App\Models\DeptuserTrans;
use App\Models\TransmittalItem;
use App\Models\Worksheet;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use App\Services\AccessRightService;

class DigesterController extends Controller
{
    protected $accessRightService;
    public function __construct(
        AccessRightService $accessRightService
    ) {
        $this->accessRightService = $accessRightService;
    }
    public function index()
    {
        $rolesPermissions = $this->accessRightService->hasPermissions("Tech/Digester Worksheets");
        if (!$rolesPermissions['view']) {
            abort(401);
        }
        return view('digester.index');
    }
    public function viewWorksheet($id)
    {
        $rolesPermissions = $this->accessRightService->hasPermissions("Tech/Digester Worksheets");
        if (!$rolesPermissions['edit']) {
            abort(401);
        }
        $worksheet = Worksheet::where('id', $id)->first();
        $forapproval = 1;
        // dd(TransmittalItem::where('labbatch', $worksheet->labbatch)->where(function ($q) {
        //     return $q->orWhereNull('samplewtgrams')
        //         ->orWhereNull('fluxg')
        //         ->orWhereNull('flourg')
        //         ->orWhereNull('niterg')
        //         ->orWhereNull('leadg')
        //         ->orWhereNull('silicang')
        //         ->orWhereNull('crusibleused');
        // })->toSql());
        $items = TransmittalItem::where('labbatch', $worksheet->labbatch)->where(function ($q) {
            return $q->orWhereNull('samplewtgrams')
                ->orWhereNull('fluxg')
                ->orWhereNull('flourg')
                ->orWhereNull('niterg')
                ->orWhereNull('leadg')
                ->orWhereNull('silicang')
                ->orWhereNull('crusibleused');
        })->get();
        if (count($items) > 0) {
            $forapproval = 0;
        }

        return view('digester.view', compact('forapproval', 'worksheet'));
    }
    public function approve(Request $request)
    {
        $request->validate(['id' => 'required']);
        try {
            $worksheet = Worksheet::find($request->id);

            $data = [
                'isApproved' => 1,
                'approved_at' => Carbon::now(),
                'approvedby' => auth()->user()->username,
            ];
            $worksheet->update($data);
            return response()->json('success');
        } catch (Exception $e) {
            return response()->json(['errors' => $e->getMessage(), 500]);
        }
    }
    public function getWorksheet(Request $request)
    {
        $currentMonth = Carbon::now()->month;

        $firstDay = Carbon::createFromDate(null, $currentMonth, 1);
        $lastDay = Carbon::createFromDate(null, $currentMonth, $firstDay->daysInMonth);

        $dateFrom = $firstDay->toDateString();
        $dateTo = $lastDay->toDateString();
        if (isset($request->dateFrom)) {
            $dateFrom = $request->dateFrom;
        }
        if (isset($request->dateTo)) {
            $dateTo = $request->dateTo;
        }

        $worksheet = Worksheet::where('isdeleted', 0)
            ->whereBetween('dateshift', [$dateFrom, $dateTo])
            ->orderBy('created_at', 'desc')->get();
        return $worksheet;
    }
    public function transmittal()
    {
        $rolesPermissions = $this->accessRightService->hasPermissions("Tech/Digester Transmittals");
        if (!$rolesPermissions['view']) {
            abort(401);
        }
        return view('digester.transmittal');
    }
    public function getTransmittal(Request $request)
    {
        // dd(DeptuserTrans::where([['isdeleted', 0],['status','Approved'],['transcode',1],['transType','Solid']])
        // ->orderBy('transmittalno', 'asc')->toSql());
        $currentMonth = Carbon::now()->month;

        $firstDay = Carbon::createFromDate(null, $currentMonth, 1);
        $lastDay = Carbon::createFromDate(null, $currentMonth, $firstDay->daysInMonth);

        $dateFrom = $firstDay->toDateString();
        $dateTo = $lastDay->toDateString();
        if (isset($request->dateFrom)) {
            $dateFrom = $request->dateFrom;
        }
        if (isset($request->dateTo)) {
            $dateTo = $request->dateTo;
        }

        $transmittal = DeptuserTrans::where([['isdeleted', 0], ['status', 'Approved'], ['transType', 'Solids']])
            ->whereBetween('datesubmitted', [$dateFrom, $dateTo])
            ->orderBy('transmittalno', 'asc')->get();

        return $transmittal;
    }
    public function edit($id)
    {
        $rolesPermissions = $this->accessRightService->hasPermissions("Tech/Digester Transmittals");
        if (!$rolesPermissions['edit']) {
            abort(401);
        }
        $transmittal = DeptuserTrans::where('id', $id)->first();
        return view('digester.edit', compact('transmittal'));
    }
    public function getItems(Request $request)
    {
        $items = TransmittalItem::where([['isdeleted', 0], ['transmittalno', $request->transmittalno], ['isAssayed', 0]])->get();
        return  $items;
    }

    public function view($id)
    {
        $rolesPermissions = $this->accessRightService->hasPermissions("Tech/Digester Transmittals");
        if (!$rolesPermissions['view']) {
            abort(401);
        }
        $transmittal = DeptuserTrans::where('id', $id)->first();
        return view('digester.view_transmittal', compact('transmittal'));
    }
    public function receive($id)
    {
        $rolesPermissions = $this->accessRightService->hasPermissions("Tech/Digester Transmittals");
        if (!$rolesPermissions['edit']) {
            abort(401);
        }
        $transmittal = DeptuserTrans::where('id', $id)->first();
        return view('digester.receive', compact('transmittal'));
    }
    public function receiveTransmittal(Request $request)
    {
        $request->validate([
            'id' => 'required'
        ]);
        try {

            $deptuserTrans = DeptuserTrans::find($request->id);

            $data = [
                'received_date' => Carbon::now(),
                'receiver' => auth()->user()->username,
                'isReceived' =>  true,
            ];
            $deptuserTrans->update($data);

            return response()->json('success');
        } catch (Exception $e) {
            return response()->json(['error' =>  $e->getMessage()], 500);
        }
    }
}
