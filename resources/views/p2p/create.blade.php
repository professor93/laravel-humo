@extends('humo::xml')
@section('body')
    <SOAP-ENV:Body>
        <ebppif1:Request SOAP-ENV:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/">
            <language>en</language>
            <switchingID>
                <value>{{$p2p->getSwitchId()}}</value>
            </switchingID>
            <autoSwitch>1</autoSwitch>
            <paymentRef>{{$p2p->getPaymentRef()}}</paymentRef>
            <details>
                <item>
                    <name>pan</name>
                    <value>{{$p2p->pan}}</value>
                </item>
                <item>
                    <name>expiry</name>
                    <value>{{$p2p->expiry}}</value>
                </item>
                <item>
                    <name>pan2</name>
                    <value>{{$p2p->pan2}}</value>
                </item>
                <item>
                    <name>amount</name>
                    <value>{{$p2p->amount}}</value>
                </item>
                <item>
                    <name>ccy_code</name>
                    <value>860</value>
                </item>
                <item>
                    <name>merchant_id</name>
                    <value>{{$p2p->merchant_id}}</value>
                </item>
                <item>
                    <name>terminal_id</name>
                    <value>{{$p2p->terminal_id}}</value>
                </item>
            </details>
            <paymentOriginator>{{$originator}}</paymentOriginator>
        </ebppif1:Request>
    </SOAP-ENV:Body>
@endsection