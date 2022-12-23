{{-- Struction not same with other views. Thats why we didn't extend layouts --}}
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:urn="urn:PaymentServer">
    <soapenv:Header/>
    <soapenv:Body>
        <urn:CancelRequest>
            @if(isset($payment_id))
                <paymentID>{{$payment_id}}</paymentID>
            @else
                <paymentRef>{{$payment_ref}}</paymentRef>
            @endif
            <paymentOriginator>{{$originator}}</paymentOriginator>
        </urn:CancelRequest>
    </soapenv:Body>
</soapenv:Envelope>
