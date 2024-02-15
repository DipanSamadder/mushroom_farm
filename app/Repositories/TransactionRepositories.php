<?php
namespace App\Repositories;
use App\Interfaces\TransactionInterfaces;
use App\Models\Transaction;

class TransactionRepositories implements TransactionInterfaces {
    public function all($request, $post_type) {
        if ($request['page'] != 1) {
            $start = $request['page'] * 15;
        } else {
            $start = 0;
        }
        $search = $request['search'];
        $sort = $request['sort'];
        $data = Transaction::where('category', $post_type);
        if ($search != '') {
            $data->where('purpose', 'like', '%' . $search . '%');
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
        $lbalance =0 ;
        $lastest  = Transaction::latest()->first();
        if(!is_null($lastest)){
            $lbalance = $lastest->balance;
        }
        $transaction = new Transaction;
        $transaction->purpose = isset($request['purpose']) ? $request['purpose'] : '';
        $transaction->category = isset($request['category']) ? $request['category'] : 'default';
        $transaction->type = isset($request['type']) ? $request['type'] : 'debit';
        $transaction->amount = isset($request['amount']) ? floatval($request['amount']) : floatval(0);

        if(isset($request['amount'])){
            if(isset($request['type']) && $request['type'] == 'debit'){
                $transaction->balance = $lbalance - floatval($request['amount']);
            }else{
                $transaction->balance = $lbalance + floatval($request['amount']);
            }
        }

        $transaction->emp_id = isset($request['emp_id']) ? $request['emp_id'] : 0;
        $transaction->date = isset($request['date']) ? $request['date'] : 0;
        $transaction->payment_mode = isset($request['payment_mode']) ? $request['payment_mode'] : 'cash';
        $transaction->created_by = isset($request['created_by']) ? $request['created_by'] : 0;
        $transaction->updated_by = isset($request['created_by']) ? $request['created_by'] : 0;
        $transaction->status = isset($request['status']) ? $request['status'] : 0;
        if ($transaction->save()) {
            return 'success';
        }
    }
    public function find($id) {
        return Transaction::find($id);
    }

    public function destory($id) {
        return $this->find($id)->delete();
    }
    public function update($id, $request) {
        $transaction = $this->find($id);
        $previousBalance = 0;

        if (isset($request['purpose'])) {
            $transaction->purpose = $request['purpose'];
        }
        if (isset($request['category'])) {
            $transaction->category = $request['category'];
        }
        if (isset($request['type'])) {
            $transaction->type = $request['type'];
        }
        if (isset($request['amount'])) {
            $transaction->amount = floatval($request['amount']);

            $previousRow = Transaction::where('id', '<', $id)->latest('id')->first();
            if(!is_null($previousRow)){
                $previousBalance = $previousRow->balance ? $previousRow->balance : $previousRow->amount;
            }
            
            if($request['type'] == 'debit'){
                $transaction->balance = $previousBalance - floatval($request['amount']);
            }else{
                $transaction->balance = $previousBalance + floatval($request['amount']);
            }
        }
        if (isset($request['emp_id'])) {
            $transaction->emp_id = $request['emp_id'];
        }
        if (isset($request['date'])) {
            $transaction->date = $request['date'];
        }
        if (isset($request['payment_mode'])) {
            $transaction->payment_mode = $request['payment_mode'];
        }
        if (isset($request['updated_by'])) {
            $transaction->updated_by = $request['updated_by'];
        }
        if (isset($request['status'])) {
            $transaction->status = $request['status'];
        }




        if ($transaction->save()) {
            if (isset($request['amount'])) { $this->balance_update($id);}
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

    public function balance_update($id){
        $previousBalance = 0;
        $rowsToUpdate = Transaction::where('id', '>=', $id)->get();
        $previousRow = Transaction::where('id', '<', $id)->latest('id')->first();

        if(!is_null($previousRow)){
            $previousBalance = $previousRow->balance;
        }

        foreach ($rowsToUpdate as $row) {
            
            
            if($row->type == 'debit'){
               $row->balance = $previousBalance - floatval($row->amount);
            }else{
               $row->balance = $previousBalance + floatval($row->amount);
            }
            $row->save();
            $previousBalance = $row->balance;
            
        }

    }
}
