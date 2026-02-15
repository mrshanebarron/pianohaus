@extends('emails._layout', ['emailType' => 'Contract Ready'])

@section('content')
    <h1 style="margin: 0 0 8px; font-family: 'Georgia', serif; font-size: 24px; color: #1a1a2e;">Your Contract Is Ready</h1>
    <p style="margin: 0 0 24px; font-family: Arial, sans-serif; font-size: 14px; color: #827c6b;">
        Hi {{ $contract->customer->first_name }}, your rental agreement is ready for review and digital signature.
    </p>

    {{-- Contract details --}}
    <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom: 24px; border: 1px solid #ede6d8; border-radius: 8px; overflow: hidden;">
        <tr>
            <td style="padding: 12px 16px; background-color: #f9f4ea;">
                <table width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                        <td style="font-family: Arial, sans-serif; font-size: 12px; color: #827c6b;">Contract Number</td>
                        <td align="right" style="font-family: Arial, sans-serif; font-size: 14px; color: #1a1a2e; font-weight: bold;">{{ $contract->contract_number }}</td>
                    </tr>
                </table>
            </td>
        </tr>
        @if($contract->rental && $contract->rental->piano)
            <tr>
                <td style="padding: 12px 16px; border-top: 1px solid #ede6d8;">
                    <table width="100%" cellpadding="0" cellspacing="0">
                        <tr>
                            <td style="font-family: Arial, sans-serif; font-size: 12px; color: #827c6b;">Piano</td>
                            <td align="right" style="font-family: Arial, sans-serif; font-size: 14px; color: #1a1a2e;">{{ $contract->rental->piano->name }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        @endif
    </table>

    <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center">
                <a href="{{ url('/contracts/' . $contract->id . '/sign') }}" style="display: inline-block; padding: 14px 40px; background-color: #c9a959; color: #1a1a2e; font-family: Arial, sans-serif; font-size: 14px; font-weight: bold; text-decoration: none; border-radius: 8px;">Review & Sign Contract</a>
            </td>
        </tr>
    </table>

    <p style="margin: 24px 0 0; font-family: Arial, sans-serif; font-size: 13px; color: #a39c89; text-align: center;">
        Your digital signature is legally binding. Please review the full agreement before signing.
    </p>
@endsection
