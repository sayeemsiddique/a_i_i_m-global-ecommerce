<div class="text-left">
    @foreach($response['element'] as $transaction)
        <div class="card mb-3">
            <div class="card-body">
                <p>
                    <strong>{{$response['no_of_trans_found'] ?? 0}} transaction(s) found.</strong>
                </p>
                <p><strong>Transaction ID:</strong> {{$transaction['tran_id'] ?? 0}}</p>
                <p><strong>Status:</strong> {{$transaction['status'] ?? ''}}</p>
                <p><strong>Amount:</strong> {{$transaction['amount'] ?? ''}} {{$transaction['currency_type'] ?? ''}}</p>
                <p><strong>Transaction Date:</strong> {{$transaction['tran_date'] ?? ''}}</p>
                <p><strong>Payment:</strong> {{$transaction['bank_gw'] ?? ''}}</p>
            </div>
        </div>
    @endforeach
</div>
