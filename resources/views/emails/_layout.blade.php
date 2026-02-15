<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body style="margin: 0; padding: 0; background-color: #f5f0e8; font-family: 'Georgia', serif;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f5f0e8; padding: 32px 16px;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="max-width: 600px; width: 100%;">
                    {{-- Header --}}
                    <tr>
                        <td style="background-color: #1a1a2e; padding: 24px 32px; border-radius: 12px 12px 0 0;">
                            <table width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td>
                                        <span style="font-family: 'Georgia', serif; font-size: 22px; font-weight: bold; color: #fcfaf5; letter-spacing: 1px;">PianoHaus</span>
                                    </td>
                                    <td align="right">
                                        <span style="font-family: Arial, sans-serif; font-size: 12px; color: #c9a959; text-transform: uppercase; letter-spacing: 2px;">{{ $emailType ?? '' }}</span>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    {{-- Gold accent bar --}}
                    <tr>
                        <td style="height: 3px; background: linear-gradient(90deg, #c9a959, #e6c56d, #c9a959);"></td>
                    </tr>

                    {{-- Body --}}
                    <tr>
                        <td style="background-color: #ffffff; padding: 32px;">
                            @yield('content')
                        </td>
                    </tr>

                    {{-- Footer --}}
                    <tr>
                        <td style="background-color: #1a1a2e; padding: 24px 32px; border-radius: 0 0 12px 12px;">
                            <p style="margin: 0 0 8px; font-family: Arial, sans-serif; font-size: 12px; color: #a39c89; text-align: center;">
                                {{ config('pianohaus.company.name') }} &middot; {{ config('pianohaus.company.address') }}
                            </p>
                            <p style="margin: 0; font-family: Arial, sans-serif; font-size: 12px; color: #a39c89; text-align: center;">
                                {{ config('pianohaus.company.phone') }} &middot; {{ config('pianohaus.company.email') }}
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
