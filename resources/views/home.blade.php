@extends('layouts.app')

@section('breadcrumbs', '')

@section('content')
<section>
    <table class="table table-bordered">
        <thead>
        <th>Pair</th>
        <th>Bid</th>
        <th>Ask</th>
        </thead>
        <tbody>
        <tr>
            <td>
                @foreach ($pairs as $pair)
                    {{$pair}}
                @endforeach
            </td>
        </tr>
        <tr>
            <td></td>
        </tr>
        <tr>
            <td>
                @foreach ($asks as $ask)
                    @foreach ($ask as $data)

                        {{var_dump($data)}}

                    @endforeach

                @endforeach
            </td>
        </tr>

        </tbody>
    </table>
</section>

@endsection
