<h2>Search Results</h2>
<ul>
    @foreach($results as $order)
        <li>Order ID: {{ $order->id }} - Patient: {{ $order->patient_id }} - Medic: {{ $order->medic_id }}</li>
    @endforeach
</ul>