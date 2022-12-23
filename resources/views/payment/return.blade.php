{{-- Struction not same with other views. Thats why we didn't extend layouts --}}
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:urn="urn:PaymentServer">
    <soapenv:Header/>
    <soapenv:Body>
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
    </soapenv:Body>
</soapenv:Envelope>
