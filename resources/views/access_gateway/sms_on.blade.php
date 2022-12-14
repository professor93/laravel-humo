@include('humo::header')
<SOAP-ENV:Envelope
    xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/"
    xmlns:ag="urn:AccessGateway">
    <SOAP-ENV:Body>
        <ag:import>
            <bankId>MB_STD</bankId>
            <cardholderName>{{$holderName}}</cardholderName>
            <cardholderID>{{$holderID}}-{{$bank_c}}</cardholderID>
            <state>on</state>
            <language>ru_translit</language>
            <Charge>
                <agreementCharge>MONTH.FEE.OFF</agreementCharge>
                <chargeAccount></chargeAccount>
            </Charge>
            <Card>
                <state>on</state>
                <pan>{{$card_number}}</pan>
                <expiry>{{$card_expiry}}</expiry>
                <Service>
                    <serviceID>MB-ALL</serviceID>
                    <serviceChannel>-</serviceChannel>
                </Service>
            </Card>
            <Phone>
                <state>on</state>
                <msisdn>{{$phone}}</msisdn>
                <deliveryChannel>-</deliveryChannel>
            </Phone>
        </ag:import>
    </SOAP-ENV:Body>
</SOAP-ENV:Envelope>
