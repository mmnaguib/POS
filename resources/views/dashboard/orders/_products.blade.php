<div id="print-area" class="text-center">
    <table class="table text-center table-hover table-bordered">
        <thead>
            <tr>
                <th>@lang('site.product')</th>
                <th>@lang('site.quantity')</th>
                <th>@lang('site.price')</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
                <tr>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->pivot->quantity }}</td>
                    <td>{{ number_format($product->pivot->quantity * $product->sale_price, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <h3>@lang('site.total'): <span>{{ number_format($order->total_price, 2) }}</span></h3>
</div>
<button class="print-btn btn btn-block btn-sm btn-primary">@lang('site.print')</button>
