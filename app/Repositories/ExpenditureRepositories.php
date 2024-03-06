<?php



namespace App\Repositories;

use App\Interfaces\ExpenditureInterfaces;

use App\Models\Expenditure;

class ExpenditureRepositories implements ExpenditureInterfaces {



    public function all($request, $work_type) {



        if ($request['page'] != 1) {

            $start = $request['page'] * 15;

        } else {

            $start = 0;

        }

        $search = $request['search'];

        $sort = $request['sort'];

        $data = Expenditure::where('purpose', '!=', '');



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



        $type = new Expenditure;

        $type->purpose = $request['purpose'];

        $type->vendor_id = $request['vendor_id'];

        $type->work_type = isset($request['work_type']) ? $request['work_type'] : 'default';

        $type->qty = isset($request['qty']) ? $request['qty'] : 0;

        $type->payment_id = isset($request['payment_id']) ? $request['payment_id'] : 0;

        $type->amount = isset($request['amount']) ? $request['amount'] : 0;

        $type->invoice_date = isset($request['invoice_date']) ? $request['invoice_date'] : 0;

        $type->delivery_date = isset($request['delivery_date']) ? $request['delivery_date'] : 0;

        $type->created_by = isset($request['created_by']) ? $request['created_by'] : 0;

        $type->updated_by = isset($request['updated_by']) ? $request['updated_by'] : 0;



        if ($type->save()) {

            return 'success';

        }



    }



    public function find($id) {

        return Expenditure::find($id);

    }



    public function destory($id) {

        return $this->find($id)->delete();

    }



    public function update($id, $request) {

        $content = isset($request['purpose']) ? $request['purpose'] : '';

        $exp = $this->find($id);

        if (isset($request['purpose'])) {

            $exp->purpose = $request['purpose'];

        }

        if (isset($request['vendor_id'])) {

            $exp->vendor_id = $request['vendor_id'];

        }

        if (isset($request['work_type'])) {

            $exp->work_type = $request['work_type'];

        }

        if (isset($request['amount'])) {

            $exp->amount = $request['amount'];

        }

    

        if (isset($request['qty'])) {

            $exp->qty = $request['qty'];

        }

        if (isset($request['payment_id'])) {

            $exp->payment_id = $request['payment_id'];

        }

        if (isset($request['invoice_date'])) {

            $exp->invoice_date = $request['invoice_date'];

        }

        if (isset($request['delivery_date'])) {

            $exp->delivery_date = $request['delivery_date'];

        }

        if (isset($request['updated_by'])) {

            $exp->updated_by = $request['updated_by'];

        }

        if ($exp->save()) {

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



}

