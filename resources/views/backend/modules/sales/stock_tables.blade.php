

<table class="table table-bordered table-striped table-hover dataTable">
    <thead>
            <tr class="text-center thead-dark">
                <th>Sr</th>
                <th>Grade</th>
                <th>Total</th>
                <th>Sold Out</th>
                <th>Stock</th>
                <th>Date</th>
            </tr>
        </thead>
    <tbody>
        @if(is_array($grades) || count($grades) > 0 )
            @foreach($grades as $rkey => $grades)
            <tr>
                <th scope="row">{{ $rkey+1 }}</th>
                <td>{{ $grades->name }}</td>
                <td>{{ dsld_total_production($grades->id) }}</td>
                <td class="text-success">{{ dsld_total_sale($grades->id) }}</td>
                <td class="text-danger">{{ dsld_total_stock($grades->id) }}</td>
                <td>{{ date('d-m-Y') }}</td>
            </tr>
            @endforeach
        @else
            <tr>
                <td colspan="8" class="text-center">Nothing Found</td>
            </tr>
        @endif
    </tbody>
</table>




