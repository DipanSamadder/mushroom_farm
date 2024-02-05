<?php
namespace App\Repositories;
use App\Interfaces\TypeInterfaces;
use App\Models\Type;
class TypeRepositories implements TypeInterfaces {
    public function all($request, $post_type) {
        if ($request['page'] != 1) {
            $start = $request['page'] * 15;
        } else {
            $start = 0;
        }
        $search = $request['search'];
        $sort = $request['sort'];
        $data = Type::where('type', $post_type);
        if ($search != '') {
            $data->where('title', 'like', '%' . $search . '%');
        }
        if ($sort != '') {
            switch ($request['sort']) {
                case 'newest':
                    $data->orderBy('created_at', 'desc');
                break;
                case 'oldest':
                    $data->orderBy('created_at', 'asc');
                break;
                case 'active':
                    $data->where('status', 1);
                break;
                case 'deactive':
                    $data->where('status', 0);
                break;
                default:
                    $data->orderBy('created_at', 'desc');
                break;
            }
        }
        return $data->skip($start)->paginate(15);
    }
    public function store($request) {
        $type = new Type;
        $type->title = $request['title'];
        $type->key_title = $request['title'];
        if (isset($request['parent'])) {
            $type->parent = $request['parent'];
            $type->level = $this->parent_level($request['parent']);
        } else {
            $type->parent = 0;
            $type->level = 1;
        }
        if (isset($request['short_content'])) {
            $type->short_content = $request['short_content'] ? $request['short_content'] : '';
        }
        $type->type = isset($request['type']) ? $request['type'] : 'default';
        $type->cat_type = isset($request['cat_type']) ? $request['cat_type'] : 0;
        $type->banner = isset($request['banner']) ? $request['banner'] : 0;
        $type->created_by = isset($request['created_by']) ? $request['created_by'] : 0;
        $type->updated_by = isset($request['updated_by']) ? $request['updated_by'] : 0;
        $type->status = isset($request['status']) ? $request['status'] : 0;
        $type->content = isset($request['content']) ? $request['content'] : '';
        if ($type->save()) {
            return 'success';
        }
    }
    public function find($id) {
        return Type::find($id);
    }

    public function destory($id) {
        return $this->find($id)->delete();
    }
    public function update($id, $request) {
        $content = isset($request['content']) ? $request['content'] : '';
        $type = $this->find($id);
        if (isset($request['title'])) {
            $type->title = $request['title'];
        }
        if (isset($request['content'])) {
            $type->content = $request['content'];
        }
        if (isset($request['short_content'])) {
            $type->short_content = $request['short_content'];
        }
    
        if (isset($request['parent'])) {
            $type->parent = $request['parent'];
        }
        if (isset($request['cat_type'])) {
            $type->cat_type = $request['cat_type'];
        }
        if (isset($request['type'])) {
            $type->type = $request['type'];
        }
        if (isset($request['order'])) {
            $type->order = $request['order'];
        }
        if (isset($request['banner'])) {
            $type->banner = $request['banner'];
        }
        if (isset($request['updated_by'])) {
            $type->updated_by = $request['updated_by'];
        }
        if (isset($request['status'])) {
            $type->status = $request['status'];
        }
        if (isset($request['thumbnail'])) {
            $type->thumbnail = $request['thumbnail'];
        }
        if (isset($request['parent'])) {
            $type->level = $this->parent_level($request['parent']);
        }
        if ($type->save()) {
            return 'success';
        }
    }
    public function status($data) {
        $type = $this->find($data['id']);
        if ($type != '') {
            if ($type->status != $data['status']) {
                $type->status = $data['status'];
                $type->save();
                return 'success';
            }
        }
        return 'nfound';
    }
    public function parent_level($parent_id) {
        if ($parent_id > 0) {
            return $this->find($parent_id)->level + 1;
        } else {
            return 1;
        }
    }
}
