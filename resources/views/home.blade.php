@extends('layouts.app')

@section('breadcrumbs', '')

@section('content')
<section>
    <div>Last Updated: {{$lastUpdated}}</div>
    <table class="table table-bordered">
        <thead>
        <th>Pair</th>
        <th>Bid (Buy)</th>
        <th>Ask (Sell)</th>
        <th>Delta</th>
        <th>Net Profit</th>
        </thead>
        <tbody>
        @if($items && count($items)>0)
            @foreach ($items as $item)
            <tr>
                <td> {{$item['pair']}}</td>
                <td>
                    max: <strong>{{$item['maxBid']}}</strong>  ({{$item['maxBidStock']}})<br>
                    min: {{$item['minBid']}}  ({{$item['minBidStock']}})
                </td>
                <td>
                    min: <strong>{{$item['minAsk']}}</strong>  ({{$item['minAskStock']}})<br>
                    max: {{$item['maxAsk']}}  ({{$item['maxAskStock']}})
                </td>
                <td>
                    @if($item['delta'] < 0)
                        <span class="text-danger">{{$item['delta']}}</span>
                    @else
                        <span class="text-success">{{$item['delta']}}</span>
                    @endif
                </td>
                <td>
                    @if($item['profit'] < 0)
                        <span class="text-danger">{{$item['profit']}}</span>
                    @else
                        <span class="text-success">{{$item['profit']}}</span>
                    @endif
                </td>
            </tr>
            @endforeach
        @endif
        </tbody>
    </table>
</section>

@endsection
