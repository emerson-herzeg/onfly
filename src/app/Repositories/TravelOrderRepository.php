<?php

namespace App\Repositories;

use App\Models\TravelOrderModel;
use App\Interfaces\TravelOrderRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class TravelOrderRepository implements TravelOrderRepositoryInterface
{
    public function index(array $filters = []){
        $query = TravelOrderModel::query();

        // Add user_id filter
        $userId = Auth::id();
        $query->where('user_id', $userId);

        if (!empty($filters)) {
            foreach ($filters as $key => $value) {
                if ($key == 'status') {
                    $query->where('status', $value);
                }
                if ($key == 'destination') {
                    $query->where('destination', 'like', '%' . $value . '%');
                }
                if ($key == 'departure_date_from') {
                    $query->whereDate('departure_date', '>=', $value);
                }
                if ($key == 'departure_date_to') {
                    $query->whereDate('departure_date', '<=', $value);
                }
            }
        }

        return $query->get();
    }

    public function getById($id){
       return TravelOrderModel::find($id);
    }

    public function store(array $data){
       return TravelOrderModel::create($data);
    }

    public function update(array $data, $id){
       return TravelOrderModel::whereId($id)->update($data);
    }

    public function delete($id){
        TravelOrderModel::destroy($id);
    }
}
