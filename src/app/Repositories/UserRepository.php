<?php

namespace App\Repositories;
use App\Models\UserModel;
use App\Interfaces\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    public function index(){
        return UserModel::all();
    }

    public function getById($id){
       return UserModel::findOrFail($id);
    }

    public function store(array $data){
       return UserModel::create($data);
    }

    public function update(array $data, $id){
       return UserModel::whereId($id)->update($data);
    }

    public function delete($id){
        UserModel::destroy($id);
    }

    public function findByEmail(string $email) {
        return UserModel::where('email', $email)->first();
    }
}
