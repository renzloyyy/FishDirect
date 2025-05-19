@foreach($availableVouchers as $voucher)
    @php
        $meetsMinOrder = $subtotal >= ($voucher->minimum_order_amount ?? 0);
        $isApplied = ($appliedCode === $voucher->code);
    @endphp
    <div class="voucher-item mb-2 p-2 border rounded">
        <div>
            <strong>{{ $voucher->code }}</strong> - 
            @if($voucher->type === 'percentage')
                {{ $voucher->discount }}% off
            @else
                ₱{{ number_format($voucher->discount, 2) }} off
            @endif
        </div>
        <div>
            Min Order: ₱{{ number_format($voucher->minimum_order_amount ?? 0, 2) }}
        </div>
        <div class="mt-1">
            @if($isApplied)
                <button class="btn btn-sm btn-danger remove-promo" data-code="{{ $voucher->code }}">Remove</button>
            @elseif($meetsMinOrder)
                <button class="btn btn-sm btn-primary apply-promo" data-code="{{ $voucher->code }}">Apply</button>
            @else
                <button class="btn btn-sm btn-secondary" disabled>Not eligible</button>
            @endif
        </div>
    </div>
@endforeach
