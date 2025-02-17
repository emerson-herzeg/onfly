<?php

namespace App\Http\Controllers;

use App\Http\Resources\TravelOrderResource;
use App\Interfaces\TravelOrderRepositoryInterface;
use App\Http\Requests\TravelOrder\StoreTravelOrderRequest;
use App\Services\TravelOrderService;
use App\Http\Requests\TravelOrder\UpdateStatusTravelOrderRequest;
use Illuminate\Http\Request;

class TravelOrderController extends Controller
{
    private TravelOrderRepositoryInterface $travelOrderRepositoryInterface;
    private TravelOrderService $travelOrderService;

    public function __construct(TravelOrderRepositoryInterface $travelOrderRepositoryInterface, TravelOrderService $travelOrderService)
    {
        parent::__construct();
        $this->travelOrderRepositoryInterface = $travelOrderRepositoryInterface;
        $this->travelOrderService = $travelOrderService;
    }

    /**
     * Display a listing of the resource.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filters = $request->query();
        $data = $this->travelOrderRepositoryInterface->index($filters);
        return $this->apiResponse->success(TravelOrderResource::collection($data), '', 200);
    }

    /**
     * Store a newly created resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTravelOrderRequest $request)
    {
        $obj = $this->travelOrderService->create($request->all());
        return $this->apiResponse->success(new TravelOrderResource($obj), '', 200);
    }

    /**
     * Display the specified resource.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     **/
    public function show($id) {
        $obj = $this->travelOrderRepositoryInterface->getById($id);
        return $this->apiResponse->success(new TravelOrderResource($obj), '', 200);
    }

    /**
     * Status update.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateStatus(UpdateStatusTravelOrderRequest $request, $id)
    {
        try {
            $data = $request->validated();
            $data['id'] = $id;
            $obj = $this->travelOrderService->updateStatus($data);
            return $this->apiResponse->success(new TravelOrderResource($obj), '', 200);
        } catch (\Exception $e) {
            return $this->apiResponse->error($e->getMessage(), [], 400);
        }
    }

    /**
     * Cancel travel order.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function cancel($id)
    {
        try {
            $obj = $this->travelOrderService->cancel($id);
            return $this->apiResponse->success(new TravelOrderResource($obj), '', 200);
        } catch (\Exception $e) {
            return $this->apiResponse->error($e->getMessage(), [], 400);
        }
    }
}
