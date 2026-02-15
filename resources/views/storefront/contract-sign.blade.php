<x-layouts.storefront :title="'Sign Contract ' . $contract->contract_number">

    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="font-display text-2xl font-bold text-ebony-800">Rental Agreement</h1>
                    <p class="text-sm font-ui text-ivory-600 mt-1">Contract {{ $contract->contract_number }}</p>
                </div>
                <span class="px-3 py-1 bg-yellow-100 text-yellow-700 text-xs font-ui font-bold rounded-full uppercase">Awaiting Signature</span>
            </div>
        </div>

        {{-- Contract Content --}}
        <div class="bg-white border border-ivory-400/50 rounded-xl p-8 mb-8 prose prose-sm max-w-none font-body text-ebony-800">
            {!! $contract->content !!}
        </div>

        {{-- Signature Pad --}}
        <div class="bg-white border border-ivory-400/50 rounded-xl p-6" x-data="signaturePad()">
            <h2 class="font-display text-lg font-semibold text-ebony-800 mb-4">Sign Below</h2>
            <p class="text-sm font-ui text-ivory-600 mb-4">Use your mouse or finger to sign in the box below. Your digital signature is legally binding.</p>

            <div class="border-2 border-dashed border-ivory-400 rounded-lg overflow-hidden mb-4 bg-ivory-50">
                <canvas x-ref="canvas" width="700" height="200" class="w-full cursor-crosshair" style="touch-action: none;"
                    @mousedown="startDrawing($event)"
                    @mousemove="draw($event)"
                    @mouseup="stopDrawing()"
                    @mouseleave="stopDrawing()"
                    @touchstart.prevent="startDrawing($event)"
                    @touchmove.prevent="draw($event)"
                    @touchend="stopDrawing()">
                </canvas>
            </div>

            <div class="flex items-center justify-between mb-6">
                <button @click="clear()" type="button" class="text-sm font-ui text-ivory-600 hover:text-red-600 transition">Clear Signature</button>
                <p class="text-xs font-ui text-ivory-500">
                    Signing as <strong class="text-ebony-800">{{ $contract->customer->full_name }}</strong>
                </p>
            </div>

            <form method="POST" action="{{ route('contract.sign.store', $contract) }}" @submit.prevent="submitSignature($event)">
                @csrf
                <input type="hidden" name="signature" x-ref="signatureInput">

                <div class="bg-gold-50 border border-gold-200 rounded-lg px-4 py-3 text-sm font-ui text-gold-800 mb-4">
                    By signing, I acknowledge that I have read and agree to all terms in this rental agreement. I understand this is a legally binding contract.
                </div>

                <button type="submit" :disabled="!hasSignature" :class="hasSignature ? 'bg-gold-500 hover:bg-gold-400' : 'bg-ivory-400 cursor-not-allowed'" class="w-full text-ebony-900 font-ui font-semibold py-3.5 rounded-lg transition-colors">
                    Sign & Accept Agreement
                </button>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        function signaturePad() {
            return {
                drawing: false,
                hasSignature: false,
                ctx: null,
                lastX: 0,
                lastY: 0,

                init() {
                    const canvas = this.$refs.canvas;
                    this.ctx = canvas.getContext('2d');
                    this.ctx.strokeStyle = '#1a1a2e';
                    this.ctx.lineWidth = 2;
                    this.ctx.lineCap = 'round';
                    this.ctx.lineJoin = 'round';
                },

                getPos(e) {
                    const rect = this.$refs.canvas.getBoundingClientRect();
                    const scaleX = this.$refs.canvas.width / rect.width;
                    const scaleY = this.$refs.canvas.height / rect.height;
                    const clientX = e.touches ? e.touches[0].clientX : e.clientX;
                    const clientY = e.touches ? e.touches[0].clientY : e.clientY;
                    return {
                        x: (clientX - rect.left) * scaleX,
                        y: (clientY - rect.top) * scaleY
                    };
                },

                startDrawing(e) {
                    this.drawing = true;
                    const pos = this.getPos(e);
                    this.lastX = pos.x;
                    this.lastY = pos.y;
                    this.ctx.beginPath();
                    this.ctx.moveTo(pos.x, pos.y);
                },

                draw(e) {
                    if (!this.drawing) return;
                    const pos = this.getPos(e);
                    this.ctx.lineTo(pos.x, pos.y);
                    this.ctx.stroke();
                    this.lastX = pos.x;
                    this.lastY = pos.y;
                    this.hasSignature = true;
                },

                stopDrawing() {
                    this.drawing = false;
                },

                clear() {
                    this.ctx.clearRect(0, 0, this.$refs.canvas.width, this.$refs.canvas.height);
                    this.hasSignature = false;
                },

                submitSignature(e) {
                    if (!this.hasSignature) return;
                    this.$refs.signatureInput.value = this.$refs.canvas.toDataURL('image/png');
                    e.target.submit();
                }
            };
        }
    </script>
    @endpush

</x-layouts.storefront>
