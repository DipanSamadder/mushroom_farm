<?php
namespace App\Interfaces;

Interface PostInterfaces{
    
    public function all(array $data, $post_type);
    public function find($id);
    public function sections($id, $section_id = null);
    public function destory($id);
    public function store(array $data);
    public function update($id, array $data);
    public function status(array $data);
}