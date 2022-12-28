@include('humo::header')
<soapenv:Envelope
    xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
    xmlns:xsd="http://www.w3.org/2001/XMLSchema"
    xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
    xmlns:bin="urn:IssuingWS/binding">
    <soapenv:Header/>
    <soapenv:Body>
        <bin:removeCardFromStop soapenv:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/">
            <ConnectionInfo xsi:type="urn:OperationConnectionInfo" xmlns:urn="urn:issuing_v_01_02_xsd">
                <BANK_C xsi:type="xsd:string">{{$bank_c}}</BANK_C>
                <GROUPC xsi:type="xsd:string">01</GROUPC>
                <EXTERNAL_SESSION_ID xsi:type="xsd:string">{{$session_id}}</EXTERNAL_SESSION_ID>
            </ConnectionInfo>
            <Parameters xsi:type="urn:RowType_RemoveCardFromStop_Request" xmlns:urn="urn:issuing_v_01_02_xsd">
                <CARD xsi:type="xsd:string">{{$card}}</CARD>
                <TEXT xsi:type="xsd:string">{{$reason}}</TEXT>
                <BANK_C xsi:type="xsd:string">{{$bank_c}}</BANK_C>
                <GROUPC xsi:type="xsd:string">01</GROUPC>
                <STOP_CAUSE xsi:type="xsd:string">0</STOP_CAUSE>
            </Parameters>
        </bin:removeCardFromStop>
    </soapenv:Body>
</soapenv:Envelope>
