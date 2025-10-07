<table class="table table-striped ">
    <thead>
        <tr style="background-color: #0bb7af6b !important;">

            <th style="color: rgb(0, 0, 0) !important;">Invoice ID</th>
            <th style="color: rgb(0, 0, 0) !important;" class="text-left">Customer</th>
            <th style="color: rgb(0, 0, 0) !important;">Total Item Quantity</th>
            <th style="color: rgb(0, 0, 0) !important;">Total Price</th>
            <th style="color: rgb(0, 0, 0) !important;">Sold By</th>

            <th style="color: rgb(0, 0, 0) !important;">Status</th>
            <th>Action</th>
        </tr>

    </thead>
    <tbody>
        @foreach ($orders as $order)
            <tr>
                <td>52.01.0000.215.01.000.12-00{{ $order->id }}</td>
                <td align="left">{{ $order->customer ? ucfirst($order->customer->first_name) . ' '. $order->customer->last_name :'Walking Customer' }}</td>
                <td>{{ number_format($order->total_quantity) }}</td>
                <td>{{ $order->discount_type ? $order->final_amount : $order->total_price }}</td>
                
                <td>{{ $order->soldBy ? ucfirst($order->soldBy->first_name) . ' '. ucfirst($order->soldBy->last_name)  : '' }}</td>
                <td>
                    @if ($order->payment_status == 'unpaid')
                        <span class="badge badge-warning">Unpaid</span>
                    @elseif($order->payment_status == 'paid')   
                        <span class="badge badge-success">Paid</span>
                    @elseif($order->payment_status == 'cancel')  
                        <span class="badge badge-danger">Cancelled</span>
                    @endif
                    
                </td>
                <td>
                    <a target="_blank" href="{{ route('admin.pos.invoice',$order) }}" class="btn btn-info">
                        @if ($order->payment_status == 'paid')
                            Invoice
                        @elseif ($order->payment_status == 'unpaid')
                            Details
                        @elseif ($order->payment_status == 'cancel')
                            Details
                        @endif
                    </a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>