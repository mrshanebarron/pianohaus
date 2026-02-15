@extends('emails._layout', ['emailType' => 'Rental Approved'])

@section('content')
    <h1 style="margin: 0 0 8px; font-family: 'Georgia', serif; font-size: 24px; color: #1a1a2e;">You're Approved!</h1>
    <p style="margin: 0 0 24px; font-family: Arial, sans-serif; font-size: 14px; color: #827c6b;">
        Great news, {{ $rental->customer->first_name }}! Your rental application for the {{ $rental->piano->name }} has been approved.
    </p>

    {{-- Rental summary --}}
    <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom: 24px; border: 1px solid #ede6d8; border-radius: 8px; overflow: hidden;">
        <tr>
            <td style="background-color: #f0fdf4; padding: 16px; text-align: center;">
                <span style="font-family: Arial, sans-serif; font-size: 14px; font-weight: bold; color: #166534; text-transform: uppercase; letter-spacing: 1px;">Approved</span>
            </td>
        </tr>
        <tr>
            <td style="padding: 12px 16px; border-top: 1px solid #ede6d8;">
                <table width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                        <td style="font-family: Arial, sans-serif; font-size: 12px; color: #827c6b;">Rental Number</td>
                        <td align="right" style="font-family: Arial, sans-serif; font-size: 14px; color: #1a1a2e; font-weight: bold;">{{ $rental->rental_number }}</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td style="padding: 12px 16px; border-top: 1px solid #ede6d8;">
                <table width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                        <td style="font-family: Arial, sans-serif; font-size: 12px; color: #827c6b;">Monthly Rate</td>
                        <td align="right" style="font-family: Arial, sans-serif; font-size: 14px; color: #1a1a2e; font-weight: bold;">{{ $rental->formatted_monthly_rate }}</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td style="padding: 12px 16px; border-top: 1px solid #ede6d8;">
                <table width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                        <td style="font-family: Arial, sans-serif; font-size: 12px; color: #827c6b;">Start Date</td>
                        <td align="right" style="font-family: Arial, sans-serif; font-size: 14px; color: #1a1a2e;">{{ $rental->start_date?->format('F j, Y') ?? 'Pending' }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    {{-- Contract signing CTA --}}
    @if($rental->contract)
        <h2 style="margin: 0 0 8px; font-family: 'Georgia', serif; font-size: 16px; color: #1a1a2e;">Next Step: Sign Your Contract</h2>
        <p style="margin: 0 0 16px; font-family: Arial, sans-serif; font-size: 13px; color: #605c4f;">
            Please review and sign your rental agreement to finalize the rental.
        </p>
        <table width="100%" cellpadding="0" cellspacing="0">
            <tr>
                <td align="center">
                    <a href="{{ url('/contracts/' . $rental->contract->id . '/sign') }}" style="display: inline-block; padding: 12px 32px; background-color: #c9a959; color: #1a1a2e; font-family: Arial, sans-serif; font-size: 14px; font-weight: bold; text-decoration: none; border-radius: 8px;">Review & Sign Contract</a>
                </td>
            </tr>
        </table>
    @else
        <p style="margin: 0 0 16px; font-family: Arial, sans-serif; font-size: 13px; color: #605c4f;">
            Your rental agreement is being prepared. You'll receive a separate email when it's ready for signing.
        </p>
    @endif

    <p style="margin: 24px 0 0; font-family: Arial, sans-serif; font-size: 13px; color: #a39c89; text-align: center;">
        Questions about your rental? Reply to this email or call {{ config('pianohaus.company.phone') }}
    </p>
@endsection
