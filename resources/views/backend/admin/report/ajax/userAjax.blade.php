<div id="printArea">
<table class="table table-separate table-head-custom table-checkable dataTable table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Photo</th>
                <th class="text-left">Full Name</th>
                <th class="text-left">Division Name</th>
                <th class="text-left">Office</th>
                <th>Mobile</th>
                <th class="text-left">Email</th>
            </tr>
        </thead>
        <tbody>
            @if ($users->count() > 0)
                @php
                    $i = (($users->currentPage() - 1) * $users->perPage() + 1);
                @endphp
                @foreach ($users as $user)
                <tr>
                    <td>{{$i}}</td>
                    <td> 
                        @if ($user->photo)
                            <img src="{{ asset('storage/users/' . $user->photo) }}" alt="Photo" style="max-width: 80px;">
                        @else
                            <img src="{{ asset('assets/media/users/blank.png') }}" alt="Photo" style="max-width: 80px;"> 
                        @endif
                        
                    </td>
                    <td align="left">{{ucfirst($user->first_name)}} {{ucfirst($user->last_name)}}</td>
                    <td align="left">{{$user->division ? $user->division->name : 'N/A' }}</td>
                    <td align="left">{{$user->office ? $user->office->name : 'N/A' }}</td>
                    <td>{{$user->mobile}}</td>
                    <td align="left">{{$user->email}}</td>
                </tr>
                @php
                    $i++;
                @endphp
                @endforeach
            @else
                <tr class="odd"><td valign="top" colspan="11" class="dataTables_empty">No matching records found</td></tr>
            @endif
            
        </tbody>
    </div>

    
</table>

<tfoot> 
    <button type="button" id="noprintbtn" class="btn btn-primary font-weight-bold float-right" onclick="return printDiv('printArea');">Print</button>
</tfoot>

@push('stackScript')
    <script type="text/javascript">
        function printDiv(divName) {
            var printContents = document.getElementById(divName).innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
        }
    </script>
@endpush