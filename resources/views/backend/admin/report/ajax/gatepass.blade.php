<table class="table table-separate table-head-custom table-checkable table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>Order ID</th>
            <th>Gatepass ID</th>
            <th>Current Status</th> 
            <th>Issue Date</th>
            <th>Issue Time</th>
            <th>Deliver Date</th>
            <th>Deliver Time</th>
        </tr>
    </thead>

    <tbody>
        @if ($gatepasses->count() > 0)

            @foreach ($gatepasses as $gatepass)
                <tr>
                    <td>
                        #{{ $loop->index + 1 }}
                    </td>
                    
                    <td>{{ $gatepass->order ? $gatepass->order->tracking_code : '' }}</td>
                    <td>{{ sprintf('%08d', $gatepass->gatepass_no) }}</td>

                    <td>
                        @if ($gatepass->order)
                            @if ($gatepass->order->stage == 1)
                                Issued
                            @elseif ($gatepass->order->delivery_date != '' && $gatepass->order->stage == 3)
                                Delivered
                            @else
                                Invalid Status
                            @endif
                        @else
                            Invalid Status
                        @endif
                    </td>

                    <td>{{ date('M d, Y', strtotime($gatepass->created_at)) }}</td>
                    <td>{{ date('h:ia', strtotime($gatepass->created_at)) }}</td>

                    <td>
                        @if ($gatepass->order)
                            @if ($gatepass->order->delivery_date != '' && $gatepass->order->stage == 3)
                                {{ date('M d, Y', strtotime($gatepass->order->delivery_date)) }}
                            @else
                                Haven't Delivered Yet!
                            @endif
                        @else
                            Haven't Delivered Yet!
                        @endif
                    </td>
                    <td>
                        @if ($gatepass->order)
                            @if ($gatepass->order->delivery_date != '' || $gatepass->order->delivery_date != NULL)
                                {{ date('h:ia', strtotime($gatepass->order->delivery_date)) }}
                            @else
                                Haven't Delivered Yet!
                            @endif
                        @else
                            Haven't Delivered Yet!
                        @endif
                    </td>
                </tr>

            @endforeach
        @else
            <tr class="odd"><td valign="top" colspan="100%" class="dataTables_empty">No matching records found</td></tr>
        @endif
    </tbody>
    <tfoot>
        <th style="text-align: left" colspan="100%">Printed by: {{auth()->user()->first_name}} {{auth()->user()->last_name}}</th>
    </tfoot>
</table>