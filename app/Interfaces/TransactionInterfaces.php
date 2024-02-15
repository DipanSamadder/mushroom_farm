<?php
namespace App\Interfaces;

Interface TransactionInterfaces{
    
    public function all(array $data, $category);
    public function find($id);
    public function destory($id);
    public function store(array $data);
    public function update($id, array $data);
    public function status(array $data);
}