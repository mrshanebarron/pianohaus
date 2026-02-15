@extends('emails._layout', ['emailType' => 'Order Confirmation'])

@section('content')
    <h1 style="margin: 0 0 8px; font-family: 'Georgia', serif; font-size: 24px; color: #1a1a2e;">Thank You for Your Order</h1>
    <p style="margin: 0 0 24px; font-family: Arial, sans-serif; font-size: 14px; color: #827c6b;">
        Hi {{ $order->customer->first_name }}, your order has been confirmed.
    </p>

    {{-- Order details --}}
    <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom: 24px; border: 1px solid #ede6d8; border-radius: 8px; overflow: hidden;">
        <tr>
            <td style="background-color: #f9f4ea; padding: 12px 16px;">
                <table width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                        <td style="font-family: Arial, sans-serif; font-size: 12px; color: #827c6b;">Order Number</td>
                        <td align="right" style="font-family: Arial, sans-serif; font-size: 14px; color: #1a1a2e; font-weight: bold;">{{ $order->order_number }}</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td style="padding: 12px 16px; border-top: 1px solid #ede6d8;">
                <table width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                        <td style="font-family: Arial, sans-serif; font-size: 12px; color: #827c6b;">Date</td>
                        <td align="right" style="font-family: Arial, sans-serif; font-size: 14px; color: #1a1a2e;">{{ $order->created_at->format('F j, Y') }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    {{-- Items --}}
    <h2 style="margin: 0 0 12px; font-family: 'Georgia', serif; font-size: 16px; color: #1a1a2e;">Items Ordered</h2>
    @foreach($order->items as $item)
        <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom: 8px; padding: 12px; background-color: #fefdfb; border: 1px solid #f5f0e8; border-radius: 6px;">
            <tr>
                <td style="font-family: Arial, sans-serif; font-size: 14px; color: #1a1a2e; font-weight: 600;">{{ $item->piano->name ?? 'Piano' }}</td>
                <td align="right" style="font-family: Arial, sans-serif; font-size: 14px; color: #1a1a2e; font-weight: bold;">${{ number_format($item->price / 100, 2) }}</td>
            </tr>
        </table>
    @endforeach

    {{-- Totals --}}
    <table width="100%" cellpadding="0" cellspacing="0" style="margin-top: 16px; border-top: 2px solid #ede6d8; padding-top: 16px;">
        <tr>
            <td style="padding: 4px 0; font-family: Arial, sans-serif; font-size: 13px; color: #827c6b;">Subtotal</td>
            <td align="right" style="padding: 4px 0; font-family: Arial, sans-serif; font-size: 13px; color: #1a1a2e;">{{ $order->formatted_subtotal }}</td>
        </tr>
        <tr>
            <td style="padding: 4px 0; font-family: Arial, sans-serif; font-size: 13px; color: #827c6b;">Tax</td>
            <td align="right" style="padding: 4px 0; font-family: Arial, sans-serif; font-size: 13px; color: #1a1a2e;">{{ $order->formatted_tax }}</td>
        </tr>
        <tr>
            <td style="padding: 4px 0; font-family: Arial, sans-serif; font-size: 13px; color: #827c6b;">Delivery</td>
            <td align="right" style="padding: 4px 0; font-family: Arial, sans-serif; font-size: 13px; color: #1a1a2e;">{{ $order->formatted_delivery_fee }}</td>
        </tr>
        <tr>
            <td style="padding: 8px 0 0; font-family: Arial, sans-serif; font-size: 16px; color: #1a1a2e; font-weight: bold; border-top: 1px solid #ede6d8;">Total</td>
            <td align="right" style="padding: 8px 0 0; font-family: Arial, sans-serif; font-size: 16px; color: #1a1a2e; font-weight: bold; border-top: 1px solid #ede6d8;">{{ $order->formatted_total }}</td>
        </tr>
    </table>

    {{-- CTA --}}
    <table width="100%" cellpadding="0" cellspacing="0" style="margin-top: 32px;">
        <tr>
            <td align="center">
                <a href="{{ url('/portal/orders/' . $order->id) }}" style="display: inline-block; padding: 12px 32px; background-color: #c9a959; color: #1a1a2e; font-family: Arial, sans-serif; font-size: 14px; font-weight: bold; text-decoration: none; border-radius: 8px;">View Order Details</a>
            </td>
        </tr>
    </table>

    <p style="margin: 24px 0 0; font-family: Arial, sans-serif; font-size: 13px; color: #a39c89; text-align: center;">
        We'll be in touch when your piano is ready for delivery.
    </p>
@endsection
