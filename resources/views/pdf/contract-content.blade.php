<h2>PIANO RENTAL AGREEMENT</h2>

<p>This Rental Agreement ("Agreement") is entered into as of <strong>{{ $rental->start_date?->format('F j, Y') ?? 'TBD' }}</strong> by and between:</p>

<p><strong>Lessor:</strong> {{ $company['name'] }}, located at {{ $company['address'] }} ("PianoHaus")</p>

<p><strong>Lessee:</strong> {{ $rental->customer->full_name }}, {{ $rental->customer->email }} ("Renter")</p>

<hr>

<h3>1. INSTRUMENT DETAILS</h3>
<ul>
    <li><strong>Piano:</strong> {{ $rental->piano->brand->name }} {{ $rental->piano->name }}</li>
    <li><strong>Serial Number:</strong> {{ $rental->piano->serial_number ?? 'N/A' }}</li>
    <li><strong>SKU:</strong> {{ $rental->piano->sku }}</li>
    <li><strong>Condition at Delivery:</strong> {{ $rental->piano->condition_label }}</li>
</ul>

<h3>2. RENTAL TERMS</h3>
<ul>
    <li><strong>Monthly Rental Rate:</strong> {{ $rental->formatted_monthly_rate }}</li>
    <li><strong>Security Deposit:</strong> {{ $rental->formatted_deposit }}</li>
    <li><strong>Minimum Rental Period:</strong> {{ $rentalTerms['minimum_months'] }} months</li>
    <li><strong>Start Date:</strong> {{ $rental->start_date?->format('F j, Y') ?? 'TBD' }}</li>
    <li><strong>Estimated End Date:</strong> {{ $rental->end_date?->format('F j, Y') ?? 'TBD' }}</li>
    <li><strong>Payment Due:</strong> 1st of each month, with a {{ $rentalTerms['grace_period_days'] }}-day grace period</li>
</ul>

<h3>3. RENT-TO-OWN OPTION</h3>
<p>Renter may apply <strong>{{ (int)($rentalTerms['rent_to_own_credit'] * 100) }}%</strong> of monthly rental payments toward the purchase price of the instrument. This credit accumulates from the first payment and may be applied at any time during or after the rental term. The security deposit is not included in the rent-to-own credit calculation.</p>

<h3>4. SECURITY DEPOSIT</h3>
<p>The security deposit of {{ $rental->formatted_deposit }} is due prior to delivery. It will be refunded within 30 days of piano return, less any charges for damage beyond normal wear. The deposit is equal to {{ $rentalTerms['deposit_multiplier'] }}x the monthly rental rate.</p>

<h3>5. DELIVERY & RETURN</h3>
<p>PianoHaus will arrange professional delivery and setup at the agreed-upon address. Upon termination, PianoHaus will arrange pickup at no additional charge. The piano must be accessible for movers and in the same condition as delivered, allowing for normal wear.</p>

<h3>6. MAINTENANCE & CARE</h3>
<p>Renter agrees to:</p>
<ul>
    <li>Keep the piano in a climate-controlled environment (65-75F, 40-50% humidity)</li>
    <li>Not move the piano without prior written consent</li>
    <li>Not attempt repairs or modifications</li>
    <li>Allow PianoHaus access for annual tuning (included at no charge)</li>
    <li>Report any damage or issues within 48 hours</li>
</ul>

<h3>7. INSURANCE</h3>
<p>Renter is responsible for insuring the piano against theft, fire, flood, and accidental damage for its full replacement value. Proof of insurance may be requested.</p>

<h3>8. TERMINATION</h3>
<p>Either party may terminate this agreement with 30 days written notice, provided the minimum rental period has been fulfilled. Early termination incurs a fee equal to one month's rent. PianoHaus may terminate immediately for non-payment exceeding 30 days.</p>

<h3>9. GOVERNING LAW</h3>
<p>This Agreement shall be governed by the laws of the State of Tennessee.</p>

<hr>

<p><em>By signing below, both parties agree to the terms and conditions set forth in this Agreement.</em></p>
