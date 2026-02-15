<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Helvetica', 'Arial', sans-serif; font-size: 11px; color: #1a1a2e; line-height: 1.6; }
        .header { background: #1a1a2e; color: #fcfaf5; padding: 25px 40px; }
        .header h1 { font-size: 22px; font-weight: 700; letter-spacing: 1px; }
        .header p { color: #c9a959; font-size: 10px; margin-top: 3px; }
        .contract-meta { padding: 15px 40px; background: #f5f0e8; border-bottom: 2px solid #c9a959; font-size: 10px; }
        .contract-meta span { margin-right: 20px; }
        .contract-meta .label { color: #827c6b; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600; }
        .content { padding: 25px 40px; }
        .content h2 { font-size: 16px; margin-bottom: 12px; color: #1a1a2e; text-align: center; text-transform: uppercase; letter-spacing: 1px; }
        .content h3 { font-size: 12px; margin: 16px 0 8px; color: #1a1a2e; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 1px solid #e8e4db; padding-bottom: 4px; }
        .content p { margin-bottom: 8px; }
        .content ul { margin: 8px 0 12px 20px; }
        .content li { margin-bottom: 4px; }
        .content hr { border: none; border-top: 2px solid #c9a959; margin: 20px 0; }
        .signatures { padding: 20px 40px 30px; }
        .signatures table { width: 100%; }
        .signatures td { vertical-align: top; padding: 10px; width: 50%; }
        .sig-line { border-top: 1px solid #1a1a2e; margin-top: 60px; padding-top: 6px; font-size: 10px; color: #827c6b; }
        .sig-image { height: 50px; margin-top: 10px; }
        .footer { background: #f5f0e8; padding: 15px 40px; text-align: center; font-size: 9px; color: #827c6b; }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $company['name'] }}</h1>
        <p>{{ $company['tagline'] }}</p>
    </div>

    <div class="contract-meta">
        <span><span class="label">Contract:</span> {{ $contract->contract_number }}</span>
        <span><span class="label">Date:</span> {{ $contract->created_at->format('M j, Y') }}</span>
        <span><span class="label">Status:</span> {{ strtoupper($contract->status) }}</span>
        @if($contract->rental)
            <span><span class="label">Rental:</span> {{ $contract->rental->rental_number }}</span>
        @endif
    </div>

    <div class="content">
        {!! $contract->content !!}
    </div>

    <div class="signatures">
        <table>
            <tr>
                <td>
                    <strong>{{ $company['name'] }}</strong>
                    <div class="sig-line">Authorized Representative</div>
                    <div style="font-size: 10px; margin-top: 4px;">Date: {{ $contract->created_at->format('M j, Y') }}</div>
                </td>
                <td>
                    <strong>{{ $contract->customer->full_name }}</strong>
                    @if($contract->customer_signature)
                        <div style="margin-top: 10px;">
                            <img src="{{ $contract->customer_signature }}" class="sig-image" alt="Signature">
                        </div>
                        <div class="sig-line">Renter Signature</div>
                        <div style="font-size: 10px; margin-top: 4px;">
                            Date: {{ $contract->customer_signed_at?->format('M j, Y') ?? 'Pending' }}
                            @if($contract->customer_ip) &middot; IP: {{ $contract->customer_ip }} @endif
                        </div>
                    @else
                        <div class="sig-line" style="margin-top: 60px;">Renter Signature</div>
                        <div style="font-size: 10px; margin-top: 4px;">Date: _______________</div>
                    @endif
                </td>
            </tr>
        </table>
    </div>

    <div class="footer">
        <p>{{ $company['name'] }} &middot; {{ $company['address'] }} &middot; {{ $company['phone'] }} &middot; {{ $company['email'] }}</p>
        <p>This document was generated on {{ now()->format('M j, Y \a\t g:i A') }}</p>
    </div>
</body>
</html>
