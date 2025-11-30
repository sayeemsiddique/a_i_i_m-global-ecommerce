<table class="main" width="100%" cellpadding="0" cellspacing="0" role="presentation" align="center">
      <!-- Header -->
      <tr>
        <td style="background-color:#ffffff;padding: 20px;">
          <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
            <tr>
              <td style="text-align:left;width:50%;">
                <img src="{{ asset('storage/setting') }}/{{ $global_setting->logo ?? '' }}" alt="Logo" height="50"> <br>
                <br>
                <br>
                <h1><strong>INVOICE</strong></h1>
              </td>
              <td style="text-align:right; vertical-align:middle;width:50%;">

                <span>{{ $global_setting->title ?? '' }}</span> <br>

                <span>Phone: {{ $global_setting->phone ?? '' }}</span> <br>
                <span>Email: {{ $global_setting->email ?? '' }}</span> <br>
                <span>{{ $global_setting->address ?? '' }}</span> <br>
                <div id="qrcode"></div>
              </td>
            </tr>
          </table>
        </td>
      </tr>
      <tr>
        <td style="background-color:#ffffff;padding: 20px;">
          <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
            <tr>
              <td style="text-align:left;width:33%;">
                <span>{{$order->orderUserInfo->first_name ?? ''}} {{$order->orderUserInfo->last_name ?? ''}}</span> <br>
                <span>{{$order->orderUserInfo->email ?? ''}}</span> <br>
                <span>{{$order->orderUserInfo->mobile ?? ''}}</span> <br>
              </td>
              <td style="text-align:center; vertical-align:middle;width:33%;">

                <strong style="font-family:Arial,Helvetica,sans-serif;">Shipping address</strong>
                <div style="font-size:13px; color:#374151; margin-top:6px;">
                    Recipient name: {{ $order->shippingAddressInfo->recipient_name ?? '' }} <br/>
					Recipient Mobile: {{ $order->shippingAddressInfo->phone_no ?? '' }} <br/>
					Recipient Address: {{ $order->shippingAddressInfo->address ?? '' }}, {{ $order->shippingAddressInfo->upazilaInfo->name ?? '' }}, {{ $order->shippingAddressInfo->districtInfo->name ?? '' }}, {{ $order->shippingAddressInfo->divisionInfo->name ?? '' }}

                </div>

              </td>
              <td style="text-align:right; vertical-align:middle;width:33%;">
                <span class="font-weight-bold"><b>Order ID:</b> {{ $order->tracking_code }}</span> <br>
				<span class="font-weight-bold"><b>Order Date:</b> {{ date('d-M-Y', strtotime($order->created_at)) }}</span> <br>
                <label class="">Order Status:</label>
                @foreach (orderStatus() as $key => $order_status)
                    @if($order->status == $key) {{$order_status}} @endif
                @endforeach
                <br>
                <label class="">Payment Status:</label>
                @foreach(paymentStatus() as $key => $payment_status)
                    @if(($order->paymentInfo->status ?? 0) == $key) {{$payment_status}} @endif
                @endforeach


              </td>
            </tr>
          </table>
        </td>
      </tr>

      <!-- Body -->
      <tr>
        <td class="content" style="background:#ffffff; padding:20px; font-family:Arial,Helvetica,sans-serif; color:#333333;">
          <h4 class="h1" style="font-family:Arial,Helvetica,sans-serif; font-size:20px; margin:0 0 8px; color:#111827;">
            Order #{{$order->tracking_code}}
          </h4>


          <!-- Quick meta (customer, total, payment) -->
          <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="margin-top:10px;">
            <tr>
              <td style="vertical-align:top; padding-right:12px;">
                <div class="meta" style="font-family:Arial,Helvetica,sans-serif;">
                  <strong>Customer</strong><br>
                  {{$order->orderUserInfo->first_name ?? ''}} {{$order->orderUserInfo->last_name ?? ''}}<br>
                  <span>{{$order->orderUserInfo->email ?? ''}}</span><br>
                  {{$order->orderUserInfo->mobile ?? ''}}
                </div>
              </td>
              <td style="vertical-align:top; text-align:right;">
                {{-- <div class="meta" style="font-family:Arial,Helvetica,sans-serif;">
                  <strong>Order total</strong><br>
                  <span style="font-size:16px; font-weight:700;">{{$global_setting->currency ?? ""}} {{ number_format($order->grand_total_price, 0, ".", "") }}</span><br>
                  <span class="muted">Payment: {{payment_method}}</span><br>
                  <span class="muted">Shipping: {{shipping_method}}</span>
                </div> --}}
              </td>
            </tr>
          </table>

          <!-- Items -->
          <div class="order-summary" style="margin-top:16px; border-radius:6px; border:1px solid #e6e9ee;">
            <table class="items-table" width="100%" cellpadding="0" cellspacing="0" role="presentation">
              <thead>
                <tr>
                  <th style="padding:12px; text-align:left;">Item</th>
                  <th style="padding:12px; text-align:center; width:80px;">Qty</th>
                  <th style="padding:12px; text-align:right; width:120px;">Price</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($order->orderDetails as $order_detail)
                <tr>
                  <td style="padding:12px; vertical-align:middle;">
                        {{ $order_detail->productInfo->name ?? '' }} <br/>
                        @if ($order_detail->varient_id > 0)
                            <span class="text-success">
                                <small>
                                        {{ $order_detail->varientDataInfo->varientTypeInfo->name ?? '' }}: {{ $order_detail->varientDataInfo->data_value ?? '' }}
                                </small>
                            </span>
                        @endif
                  </td>
                  <td style="padding:12px; text-align:center; vertical-align:middle;">
                    {{$order_detail->quantity}}
                  </td>
                  <td style="padding:12px; text-align:right; vertical-align:middle; font-family:Arial,Helvetica,sans-serif;">
                    <div>
                        {{$global_setting->currency ?? ""}}
                        @php
                            $sub_total = $order_detail->price * $order_detail->quantity;
                        @endphp
                        {{ number_format($sub_total, 0, ".", "") }}
                    </div>
                  </td>
                </tr>
                @endforeach
                <!-- END item row -->
              </tbody>

              <!-- Totals block -->
              <tfoot>
                <tr class="total-row">
                  <td colspan="2" style="padding:12px; text-align:right;">Subtotal</td>
                  <td style="padding:12px; text-align:right;">{{$global_setting->currency ?? ""}} {{ number_format($order->total_price, 0, ".", "") }}</td>
                </tr>
                @if ($order->voucher_id > 0 and $order->voucher_discount > 0)
                    <tr>
                        <td colspan="2" style="padding:12px; text-align:right;"><strong>Voucher Discount</strong></td>
                        <td colspan="1" style="padding:12px; text-align:right;">{{ number_format($order->voucher_discount, 0, '.', '') }}</td>
                    </tr>
                @endif
                <tr class="total-row">
                  <td colspan="2" style="padding:12px; text-align:right;">Shipping Cost</td>
                  <td style="padding:12px; text-align:right;">{{$global_setting->currency ?? ""}} {{ number_format($order->shipping_cost, 0, ".", "") }}</td>
                </tr>

                <tr class="total-row">
                  <td colspan="2" style="padding:12px; text-align:right; font-size:16px;">Total</td>
                  <td style="padding:12px; text-align:right; font-size:16px; font-weight:700;">{{$global_setting->currency ?? ""}} {{ number_format($order->grand_total_price, 0, ".", "") }}</td>
                </tr>
              </tfoot>
            </table>
          </div>




          <p style="margin:18px 0 0; font-size:13px; color:#6b7280; font-family:Arial,Helvetica,sans-serif;">
            Note: This invoice was generated automatically.
          </p>
        </td>
      </tr>

    </table>
