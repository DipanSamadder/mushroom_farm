<?php
namespace App\Interfaces;

Interface ExpenditureInterfaces{
    
    public function all(array $data, $work_type);
    public function find($id);
    public function destory($id);
    public function store(array $data);
    public function update($id, array $data);
    public function status(array $data);
}