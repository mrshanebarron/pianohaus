<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Helvetica', 'Arial', sans-serif; font-size: 12px; color: #1a1a2e; line-height: 1.5; }
        .header { background: #1a1a2e; color: #fcfaf5; padding: 30px 40px; }
        .header h1 { font-size: 24px; font-weight: 700; letter-spacing: 1px; }
        .header p { color: #c9a959; font-size: 11px; margin-top: 4px; }
        .meta { padding: 24px 40px; border-bottom: 1px solid #e8e4db; }
        .meta table { width: 100%; }
        .meta td { vertical-align: top; padding: 4px 0; }
        .meta .label { color: #827c6b; font-size: 10px; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600; }
        .meta .value { font-size: 13px; font-weight: 600; }
        .items { padding: 20px 40px; }
        .items table { width: 100%; border-collapse: collapse; }
        .items th { background: #f5f0e8; padding: 10px 12px; text-align: left; font-size: 10px; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600; color: #827c6b; border-bottom: 2px solid #c9a959; }
        .items td { padding: 12px 12px; border-bottom: 1px solid #f0ece3; }
        .items .amount { text-align: right; }
        .totals { padding: 0 40px 30px; }
        .totals table { width: 260px; margin-left: auto; }
        .totals td { padding: 6px 12px; }
        .totals .total-row { border-top: 2px solid #1a1a2e; font-weight: 700; font-size: 14px; }
        .totals .label { color: #827c6b; }
        .footer { background: #f5f0e8; padding: 20px 40px; text-align: center; }
        .footer p { font-size: 10px; color: #827c6b; }
        .status-badge { display: inline-block; padding: 3px 10px; border-radius: 4px; font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; }
        .status-paid { background: #dcfce7; color: #166534; }
        .status-sent { background: #dbeafe; color: #1e40af; }
        .status-overdue { background: #fee2e2; color: #991b1b; }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $company['name'] }}</h1>
        <p>{{ $company['tagline'] }}</p>
    </div>

    <div class="meta">
        <table>
            <tr>
                <td style="width: 50%;">
                    <div class="label">Invoice To</div>
                    <div class="value">{{ $invoice->customer->full_name }}</div>
                    <div>{{ $invoice->customer->email }}</div>
                    @if($invoice->customer->phone)<div>{{ $invoice->customer->phone }}</div>@endif
                    @if($invoice->customer->address_line_1)<div>{{ $invoice->customer->full_address }}</div>@endif
                </td>
                <td style="width: 50%; text-align: right;">
                    <div class="label">Invoice Number</div>
                    <div class="value">{{ $invoice->invoice_number }}</div>
                    <div style="margin-top: 8px;">
                        <span class="label">Date: </span>{{ $invoice->created_at->format('M j, Y') }}
                    </div>
                    <div>
                        <span class="label">Due: </span>{{ $invoice->due_date->format('M j, Y') }}
                    </div>
                    <div style="margin-top: 8px;">
                        <span class="status-badge status-{{ $invoice->status }}">{{ $invoice->status_label }}</span>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    @if($invoice->order)
    <div style="padding: 10px 40px; font-size: 11px; color: #827c6b;">
        Reference: Order {{ $invoice->order->order_number }}
    </div>
    @elseif($invoice->rental)
    <div style="padding: 10px 40px; font-size: 11px; color: #827c6b;">
        Reference: Rental {{ $invoice->rental->rental_number }}
    </div>
    @endif

    <div class="items">
        <table>
            <thead>
                <tr>
                    <th style="width: 50%;">Description</th>
                    <th class="amount">Qty</th>
                    <th class="amount">Unit Price</th>
                    <th class="amount">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($invoice->items as $item)
                <tr>
                    <td>{{ $item->description }}</td>
                    <td class="amount">{{ $item->quantity }}</td>
                    <td class="amount">{{ $item->formatted_unit_price }}</td>
                    <td class="amount">{{ $item->formatted_total }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="totals">
        <table>
            <tr>
                <td class="label">Subtotal</td>
                <td class="amount">${{ number_format($invoice->subtotal / 100, 2) }}</td>
            </tr>
            @if($invoice->tax_amount > 0)
            <tr>
                <td class="label">Tax</td>
                <td class="amount">${{ number_format($invoice->tax_amount / 100, 2) }}</td>
            </tr>
            @endif
            <tr class="total-row">
                <td>Total</td>
                <td class="amount">{{ $invoice->formatted_total }}</td>
            </tr>
            @if($invoice->paid_amount > 0 && $invoice->paid_amount < $invoice->total)
            <tr>
                <td class="label">Paid</td>
                <td class="amount">${{ number_format($invoice->paid_amount / 100, 2) }}</td>
            </tr>
            <tr class="total-row">
                <td>Balance Due</td>
                <td class="amount">{{ $invoice->formatted_balance_due }}</td>
            </tr>
            @endif
        </table>
    </div>

    <div class="footer">
        <p>{{ $company['name'] }} &middot; {{ $company['address'] }}</p>
        <p>{{ $company['phone'] }} &middot; {{ $company['email'] }}</p>
        <p style="margin-top: 8px;">Thank you for your business.</p>
    </div>
</body>
</html>
