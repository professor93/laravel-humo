@extends('humo::xml')
@section('body')
    <SOAP-ENV:Body>
        <urn:ReturnPayment>
            @if(isset($payment_id))
                <paymentID>{{$payment_id}}</paymentID>
            @else
                <paymentRef>{{$payment_ref}}</paymentRef>
            @endif
            <item>
                <name>merchant_id</name>
                <value>{{$merchant_id}}</value>
            </item>
            <item>
                <name>centre_id</name>
                <value>{{$centre_id}}</value>
            </item>
            <item>
                <name>terminal_id</name>
                <value>{{$terminal_id}}</value>
            </item>
            <paymentOriginator>{{$originator}}</paymentOriginator>
        </urn:ReturnPayment>
    </SOAP-ENV:Body>
@endsection
