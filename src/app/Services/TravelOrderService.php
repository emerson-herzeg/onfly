<?php

namespace App\Services;
use App\Models\TravelOrderModel;
use App\Interfaces\TravelOrderRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use App\Events\TravelOrderStatusUpdated;

class TravelOrderService
{
    private TravelOrderRepositoryInterface $travelOrderRepositoryInterface;

    public function __construct(TravelOrderRepositoryInterface $travelOrderRepositoryInterface)
    {
        $this->travelOrderRepositoryInterface = $travelOrderRepositoryInterface;
    }

    public function create(array $data): TravelOrderModel
    {
        $userId = Auth::id();
        $data['user_id'] = $userId;
        return  $this->travelOrderRepositoryInterface->store($data);
    }

    public function updateStatus(array $data) {
        $userId = Auth::id();
        $travelOrder = $this->travelOrderRepositoryInterface->getById($data['id']);
        if (!$travelOrder) {
            throw new \Exception('Travel Order not found');
        }
        if ($travelOrder->user_id !== $userId) {
            throw new AccessDeniedHttpException('You are not authorized to update this Travel Order.');
        }
        $travelOrder->status = $data['status'];
        $this->travelOrderRepositoryInterface->update($data, $travelOrder->id);

        event(new TravelOrderStatusUpdated($travelOrder));

        return $travelOrder;
    }

    public function cancel($id) {
        $userId = Auth::id();
        $travelOrder = $this->travelOrderRepositoryInterface->getById($id);
        if (!$travelOrder) {
            throw new \Exception('Travel Order not found');
        }
        if ($travelOrder->user_id !== $userId) {
            throw new AccessDeniedHttpException('You are not authorized to cancel this Travel Order.');
        }
        if ($travelOrder->departure_date < now()) {
            throw new \Exception('Travel Order cannot be canceled after departure date.');
        }
        $travelOrder->status = 'canceled';
        $this->travelOrderRepositoryInterface->update(['status' => 'canceled'], $travelOrder->id);

        event(new TravelOrderStatusUpdated($travelOrder));
    }
}
