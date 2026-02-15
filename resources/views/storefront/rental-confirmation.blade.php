<x-layouts.storefront title="Application Submitted">

    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

        {{-- Success Icon --}}
        <div class="text-center mb-8">
            <div class="w-20 h-20 bg-gold-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-10 h-10 text-gold-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z"/></svg>
            </div>
            <h1 class="font-display text-3xl font-bold text-ebony-800 mb-2">Application Received!</h1>
            <p class="text-sm font-ui text-ivory-700">We'll review your rental application and contact you within 24 hours.</p>
        </div>

        {{-- Application Details --}}
        <div class="bg-white border border-ivory-400/50 rounded-xl overflow-hidden">
            <div class="bg-ivory-200/50 px-6 py-4 border-b border-ivory-400/30">
                <div class="flex items-center justify-between">
                    <div>
                        <span class="text-xs font-ui font-semibold text-ivory-600 uppercase tracking-wider">Application Number</span>
                        <p class="text-lg font-display font-bold text-ebony-800">{{ $rental->rental_number }}</p>
                    </div>
                    <span class="px-3 py-1 bg-yellow-100 text-yellow-700 text-xs font-ui font-bold rounded-full uppercase">{{ $rental->status_label }}</span>
                </div>
            </div>

            <div class="p-6">
                {{-- Piano --}}
                <div class="flex gap-4 mb-6 pb-6 border-b border-ivory-400/30">
                    @if($rental->piano->primary_photo_url)
                        <div class="w-24 h-18 bg-ivory-200 rounded-lg overflow-hidden flex-shrink-0">
                            <img src="{{ $rental->piano->primary_photo_url }}" alt="{{ $rental->piano->name }}" class="w-full h-full object-cover">
                        </div>
                    @endif
                    <div>
                        <span class="text-xs font-ui font-medium text-gold-600 uppercase tracking-wider">{{ $rental->piano->brand->name }}</span>
                        <h3 class="font-display text-base font-semibold text-ebony-800 mt-0.5">{{ $rental->piano->name }}</h3>
                    </div>
                </div>

                {{-- Rental Terms --}}
                <dl class="grid grid-cols-2 gap-y-3 gap-x-6 text-sm font-ui">
                    <div>
                        <dt class="text-ivory-600">Monthly Rate</dt>
                        <dd class="font-semibold text-ebony-800 mt-0.5">{{ $rental->formatted_monthly_rate }}</dd>
                    </div>
                    <div>
                        <dt class="text-ivory-600">Security Deposit</dt>
                        <dd class="font-semibold text-ebony-800 mt-0.5">{{ $rental->formatted_deposit }}</dd>
                    </div>
                    @if($rental->start_date)
                    <div>
                        <dt class="text-ivory-600">Requested Start</dt>
                        <dd class="font-semibold text-ebony-800 mt-0.5">{{ $rental->start_date->format('M j, Y') }}</dd>
                    </div>
                    @endif
                    @if($rental->end_date)
                    <div>
                        <dt class="text-ivory-600">Estimated End</dt>
                        <dd class="font-semibold text-ebony-800 mt-0.5">{{ $rental->end_date->format('M j, Y') }}</dd>
                    </div>
                    @endif
                    @if($rental->duration_months)
                    <div>
                        <dt class="text-ivory-600">Duration</dt>
                        <dd class="font-semibold text-ebony-800 mt-0.5">{{ $rental->duration_months }} months</dd>
                    </div>
                    @endif
                </dl>

                {{-- Customer Info --}}
                <div class="mt-6 pt-4 border-t border-ivory-400/30 text-sm font-ui">
                    <span class="text-xs font-semibold text-ivory-600 uppercase tracking-wider">Applicant</span>
                    <p class="text-ebony-800 mt-1">{{ $rental->customer->full_name }}</p>
                    <p class="text-ivory-600">{{ $rental->customer->email }}</p>
                </div>
            </div>
        </div>

        {{-- Next Steps --}}
        <div class="bg-gold-50 border border-gold-200 rounded-xl p-6 mt-6">
            <h3 class="font-display text-base font-semibold text-gold-800 mb-3">What Happens Next</h3>
            <ol class="space-y-2 text-sm font-ui text-gold-800">
                <li class="flex items-start gap-3">
                    <span class="w-5 h-5 bg-gold-200 rounded-full flex items-center justify-center flex-shrink-0 text-xs font-bold text-gold-800">1</span>
                    <span>We review your application within 24 hours.</span>
                </li>
                <li class="flex items-start gap-3">
                    <span class="w-5 h-5 bg-gold-200 rounded-full flex items-center justify-center flex-shrink-0 text-xs font-bold text-gold-800">2</span>
                    <span>Once approved, we'll send your rental agreement for digital signing.</span>
                </li>
                <li class="flex items-start gap-3">
                    <span class="w-5 h-5 bg-gold-200 rounded-full flex items-center justify-center flex-shrink-0 text-xs font-bold text-gold-800">3</span>
                    <span>Pay your security deposit and first month's rent.</span>
                </li>
                <li class="flex items-start gap-3">
                    <span class="w-5 h-5 bg-gold-200 rounded-full flex items-center justify-center flex-shrink-0 text-xs font-bold text-gold-800">4</span>
                    <span>We deliver, set up, and tune your piano at your location.</span>
                </li>
            </ol>
        </div>

        <div class="text-center mt-8">
            <a href="{{ route('catalog') }}" class="inline-flex items-center gap-2 text-sm font-ui font-medium text-gold-600 hover:text-gold-700 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
                Browse More Pianos
            </a>
        </div>
    </div>

</x-layouts.storefront>
