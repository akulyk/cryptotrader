@extends('layouts.app')

@section('breadcrumbs', '')

@section('title','Currency '.$currency)

@section('content')

    <section>
        <div class="form-group">
            <form class="row" action="{{route('currency')}}">
                <div class="col-md-2">
                    <select name="currency" class="form-control">
                        <option value="btc_usd">btc_usd</option>
                        <option value="eth_usd">eth_usd</option>
                        <option value="zec_usd">zec_usd</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-info">Get</button>
                </div>
            </form>
        </div>
        <div>Last Updated: {{$lastUpdated}}</div>
        <div>Currency: <strong>{{$currency}}</strong></div>
        <div class="row">
            <div class="col-md-6">
                <div class="text-dark text-center">Buy</div>
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                        @foreach($items as $stockName => $currency)
                            <td>
                                Stock: <strong>{{$stockName}}</strong><br>
                                @foreach($currency as $currencyName => $data)
                                    @if($data['bids'] && is_array($data['bids']))
                                        @foreach($data['bids'] as $bid)
                                        Price:{{round($bid[0],2)}}; Amount:{{$bid[1]}}
                                            <hr>
                                        @endforeach
                                    @endif
                                @endforeach
                            </td>
                        @endforeach
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-6">
                <div class="text-dark text-center">Sell</div>
                <table class="table table-bordered">
                    <tbody>
                    <tr>
                        @foreach($items as $stockName => $currency)
                            <td>
                                Stock: <strong>{{$stockName}}</strong><br>
                                @foreach($currency as $currencyName => $data)
                                    @if($data['asks'] && is_array($data['asks']))
                                        @foreach($data['asks'] as $ask)
                                            Price:{{round($ask[0],4)}}; Amount:{{$ask[1]}}
                                            <hr>

                                        @endforeach
                                    @endif
                                @endforeach
                            </td>
                        @endforeach
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

@endsection
