@include('humo::header')
<soapenv:Envelope
    xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
    xmlns:urn="urn:IIACardServices">
    <soapenv:Header/>
    <soapenv:Body>
        <urn:getCardAccountsBalance>
            <primaryAccountNumber>{{$card_number}}</primaryAccountNumber>
        </urn:getCardAccountsBalance>
    </soapenv:Body>
</soapenv:Envelope>
