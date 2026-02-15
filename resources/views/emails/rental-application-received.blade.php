@extends('emails._layout', ['emailType' => 'Rental Application'])

@section('content')
    <h1 style="margin: 0 0 8px; font-family: 'Georgia', serif; font-size: 24px; color: #1a1a2e;">Application Received</h1>
    <p style="margin: 0 0 24px; font-family: Arial, sans-serif; font-size: 14px; color: #827c6b;">
        Hi {{ $rental->customer->first_name }}, we've received your rental application and it's being reviewed.
    </p>

    {{-- Rental details --}}
    <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom: 24px; border: 1px solid #ede6d8; border-radius: 8px; overflow: hidden;">
        <tr>
            <td style="background-color: #f9f4ea; padding: 12px 16px;">
                <table width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                        <td style="font-family: Arial, sans-serif; font-size: 12px; color: #827c6b;">Application Number</td>
                        <td align="right" style="font-family: Arial, sans-serif; font-size: 14px; color: #1a1a2e; font-weight: bold;">{{ $rental->rental_number }}</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td style="padding: 12px 16px; border-top: 1px solid #ede6d8;">
                <table width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                        <td style="font-family: Arial, sans-serif; font-size: 12px; color: #827c6b;">Piano</td>
                        <td align="right" style="font-family: Arial, sans-serif; font-size: 14px; color: #1a1a2e;">{{ $rental->piano->name }}</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td style="padding: 12px 16px; border-top: 1px solid #ede6d8;">
                <table width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                        <td style="font-family: Arial, sans-serif; font-size: 12px; color: #827c6b;">Monthly Rate</td>
                        <td align="right" style="font-family: Arial, sans-serif; font-size: 14px; color: #1a1a2e; font-weight: bold;">{{ $rental->formatted_monthly_rate }}/mo</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td style="padding: 12px 16px; border-top: 1px solid #ede6d8;">
                <table width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                        <td style="font-family: Arial, sans-serif; font-size: 12px; color: #827c6b;">Security Deposit</td>
                        <td align="right" style="font-family: Arial, sans-serif; font-size: 14px; color: #1a1a2e;">{{ $rental->formatted_deposit }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    {{-- What's next --}}
    <h2 style="margin: 0 0 12px; font-family: 'Georgia', serif; font-size: 16px; color: #1a1a2e;">What Happens Next</h2>
    <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td style="padding: 8px 0; font-family: Arial, sans-serif; font-size: 13px; color: #605c4f;">
                <strong style="color: #c9a959;">1.</strong> Our team reviews your application (typically within 24 hours)
            </td>
        </tr>
        <tr>
            <td style="padding: 8px 0; font-family: Arial, sans-serif; font-size: 13px; color: #605c4f;">
                <strong style="color: #c9a959;">2.</strong> You'll receive a decision via email
            </td>
        </tr>
        <tr>
            <td style="padding: 8px 0; font-family: Arial, sans-serif; font-size: 13px; color: #605c4f;">
                <strong style="color: #c9a959;">3.</strong> If approved, we'll send your rental agreement for digital signature
            </td>
        </tr>
    </table>

    <p style="margin: 24px 0 0; font-family: Arial, sans-serif; font-size: 13px; color: #a39c89; text-align: center;">
        Questions? Reply to this email or call us at {{ config('pianohaus.company.phone') }}
    </p>
@endsection
