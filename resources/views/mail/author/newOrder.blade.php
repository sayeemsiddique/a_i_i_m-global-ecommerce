<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>New Order Notification</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <style>
    /* === Embedded styles (some clients will use these) === */
    body { margin:0; padding:0; -webkit-text-size-adjust:100%; -ms-text-size-adjust:100%; background-color:#f4f6f8; }
    table { border-collapse:collapse; }
    img { border:0; line-height:100%; outline:none; text-decoration:none; display:block; }
    a { color:#1a73e8; text-decoration:none; }
    .wrapper { width:100%; table-layout:fixed; background-color:#f4f6f8; padding:20px 0; }
    .main { background:#ffffff; margin:0 auto; width:600px; border-radius:8px; overflow:hidden; }
    .header { padding:20px; text-align:left; }
    .logo { max-width:160px; height:auto; }
    .content { padding:20px; font-family:Arial,Helvetica,sans-serif; color:#333333; font-size:14px; line-height:1.4; }
    .h1 { font-size:20px; font-weight:700; margin:0 0 8px; color:#111827; }
    .muted { color:#6b7280; font-size:13px; }
    .order-summary { width:100%; margin-top:16px; border:1px solid #e6e9ee; border-radius:6px; overflow:hidden; }
    .order-row { display:block; width:100%; }
    .items-table { width:100%; border-spacing:0; font-size:13px; }
    .items-table th { text-align:left; padding:12px; background:#fafbfd; border-bottom:1px solid #e6e9ee; font-weight:600; color:#111827; }
    .items-table td { padding:12px; border-bottom:1px solid #eef1f6; vertical-align:middle; }
    .price { text-align:right; white-space:nowrap; }
    .total-row td { font-weight:700; background:#fbfbfd; }
    .btn { display:inline-block; padding:10px 16px; background:#1a73e8; color:#ffffff; border-radius:6px; text-decoration:none; font-weight:600; }
    .meta { font-size:13px; color:#374151; margin-top:12px; }
    .footer { padding:16px 20px; font-size:12px; color:#6b7280; text-align:center; }
    /* Responsive */
    @media only screen and (max-width:620px) {
      .main { width:94% !important; }
      .items-table th, .items-table td { padding:10px !important; font-size:13px !important; }
      .logo { max-width:120px !important; }
    }
  </style>
</head>
<body>
  <center class="wrapper">
    <table class="main" width="600" cellpadding="0" cellspacing="0" role="presentation" align="center">
      <!-- Header -->
      <tr>
        <td class="header" style="background-color:#ffffff;">
          <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
            <tr>
              <td style="text-align:left;">
                <!-- Replace with your logo URL -->
                {{-- <img src="{{logo_url}}" alt="Store Name" class="logo" style="max-width:160px; height:auto;"> --}}
              </td>
              <td style="text-align:right; vertical-align:middle;">
                <span class="muted" style="font-family:Arial,Helvetica,sans-serif; font-size:13px;">Order ID: {{$order->tracking_code}}</span>
              </td>
            </tr>
          </table>
        </td>
      </tr>

      <!-- Body -->
      <tr>
        <td class="content" style="background:#ffffff; padding:20px; font-family:Arial,Helvetica,sans-serif; color:#333333;">
          <h1 class="h1" style="font-family:Arial,Helvetica,sans-serif; font-size:20px; margin:0 0 8px; color:#111827;">
            New order placed — #{{$order->tracking_code}}
          </h1>
          <p class="muted" style="margin:0 0 14px;">
            Hi {{$user->first_name}} {{$user->last_name}}, a new order was placed on {{$order->created_at->format('d-m-Y')}}.
          </p>

          <!-- Quick meta (customer, total, payment) -->
          <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="margin-top:10px;">
            <tr>
              <td style="vertical-align:top; padding-right:12px;">
                <div class="meta" style="font-family:Arial,Helvetica,sans-serif;">
                  <strong>Customer</strong><br>
                  {{$order->orderUserInfo->first_name ?? ''}} {{$order->orderUserInfo->last_name ?? ''}}<br>
                  <a href="mailto:{{$order->orderUserInfo->email ?? ''}}">{{$order->orderUserInfo->email ?? ''}}</a><br>
                  {{$order->orderUserInfo->mobile ?? ''}}
                </div>
              </td>
              <td style="vertical-align:top; text-align:right;">
                {{-- <div class="meta" style="font-family:Arial,Helvetica,sans-serif;">
                  <strong>Order total</strong><br>
                  <span style="font-size:16px; font-weight:700;">{{$global_setting->currency ?? ""}} {{ number_format($order->grand_total_price, 2, ".", "") }}</span><br>
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
                        {{ number_format($sub_total, 2, ".", "") }}
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
                  <td style="padding:12px; text-align:right;">{{$global_setting->currency ?? ""}} {{ number_format($order->total_price, 2, ".", "") }}</td>
                </tr>
                <tr class="total-row">
                  <td colspan="2" style="padding:12px; text-align:right;">Shipping Cost</td>
                  <td style="padding:12px; text-align:right;">{{$global_setting->currency ?? ""}} {{ number_format($order->shipping_cost, 2, ".", "") }}</td>
                </tr>
                <tr class="total-row">
                  <td colspan="2" style="padding:12px; text-align:right; font-size:16px;">Total</td>
                  <td style="padding:12px; text-align:right; font-size:16px; font-weight:700;">{{$global_setting->currency ?? ""}} {{ number_format($order->grand_total_price, 2, ".", "") }}</td>
                </tr>
              </tfoot>
            </table>
          </div>

          <!-- Addresses -->
          <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="margin-top:16px;">
            <tr>
              <td style="vertical-align:top; padding-right:12px; width:100%;">
                <strong style="font-family:Arial,Helvetica,sans-serif;">Shipping address</strong>
                <div style="font-size:13px; color:#374151; margin-top:6px;">
                    Recipient name: {{ $order->shippingAddressInfo->recipient_name ?? '' }} <br/>
					Recipient Mobile: {{ $order->shippingAddressInfo->phone_no ?? '' }} <br/>
					Recipient Address: {{ $order->shippingAddressInfo->address ?? '' }}, {{ $order->shippingAddressInfo->upazilaInfo->name ?? '' }}, {{ $order->shippingAddressInfo->districtInfo->name ?? '' }}, {{ $order->shippingAddressInfo->divisionInfo->name ?? '' }}

                </div>
              </td>
              {{-- <td style="vertical-align:top; width:50%;">
                <strong style="font-family:Arial,Helvetica,sans-serif;">Billing address</strong>
                <div style="font-size:13px; color:#374151; margin-top:6px;">
                  {{billing_name}}<br>
                  {{billing_line1}}<br>
                  {{billing_line2}}<br>
                  {{billing_city}}, {{billing_state}} {{billing_zip}}<br>
                  {{billing_country}}
                </div>
              </td> --}}
            </tr>
          </table>

          <!-- Action buttons -->
          <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="margin-top:18px;">
            <tr>
              <td style="text-align:left;">
                <a href="{{url('/admin')}}" class="btn" style="display:inline-block; background:#1a73e8; color:#fff; padding:10px 16px; border-radius:6px; text-decoration:none; font-weight:600; font-family:Arial,Helvetica,sans-serif;">
                  View order
                </a>
                &nbsp;
                {{-- <a href="{{admin_mark_shipped_url}}" style="display:inline-block; padding:10px 16px; border-radius:6px; text-decoration:none; font-weight:600; font-family:Arial,Helvetica,sans-serif; border:1px solid #e6e9ee; color:#374151;">
                  Mark as shipped
                </a> --}}
              </td>
            </tr>
          </table>

          <p style="margin:18px 0 0; font-size:13px; color:#6b7280; font-family:Arial,Helvetica,sans-serif;">
            Note: This email was generated automatically.
          </p>
        </td>
      </tr>

      <!-- Footer -->
      <tr>
        <td class="footer" style="background:#ffffff; padding:16px 20px; font-family:Arial,Helvetica,sans-serif; color:#6b7280; font-size:12px; text-align:center;">
          <div>If you don't want to receive these notifications, adjust your notification settings in the admin panel.</div>
          <div style="margin-top:8px;">© {{date('Y')}} {{$global_setting->title ?? ""}} • <a href="{{url('/')}}" style="color:#6b7280;">Visit Store</a></div>
        </td>
      </tr>
    </table>
  </center>
</body>
</html>
