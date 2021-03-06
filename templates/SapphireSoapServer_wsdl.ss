<?xml version="1.0"?>
<definitions name="SapphireSoapServer" 
xmlns="http://schemas.xmlsoap.org/wsdl/" 
xmlns:wsdl="http://schemas.xmlsoap.org/wsdl/" 
xmlns:soap="http://schemas.xmlsoap.org/wsdl/soap/" 
xmlns:xsd="http://www.w3.org/2001/XMLSchema" 
xmlns:tns="{$ServiceURL}wsdl" 
targetNamespace="{$ServiceURL}wsdl">
	<wsdl:documentation>
		Service: Sapphire SOAP Server
	</wsdl:documentation>
	<% loop Methods %>
	<message name="{$Name}Request" targetNamespace="$CurrentPage.TargetNamespace">
		<% loop Arguments %>
		<part name="$Name" type="$Type"/>
		<% end_loop %>
	</message>
	<message name="{$Name}Response" targetNamespace="$CurrentPage.TargetNamespace">
		<part name="{$Name}Return" type="$ReturnType" />
	</message>
	<% end_loop %>

	<portType name="SapphireSOAP_methodsPortType">
		<% loop Methods %>
		<operation name="$Name">
			<input message="tns:{$Name}Request"/>
			<output message="tns:{$Name}Response"/>
		</operation>
		<% end_loop %>
	</portType>
	<binding name="SapphireSOAP_methodsBinding" type="tns:SapphireSOAP_methodsPortType">
		<soap:binding style="rpc" transport="http://schemas.xmlsoap.org/soap/http"/>
		<% loop Methods %>
		<operation name="$Name">
			<soap:operation soapAction="$CurrentPage.ServiceURL?method=$Name" style="rpc"/>
			<input>
				<soap:body use="encoded" namespace="$CurrentPage.TargetNamespace" encodingStyle="http://schemas.xmlsoap.org/soap/encoding/"/>
			</input>
			<output>
				<soap:body use="encoded" namespace="$CurrentPage.TargetNamespace" encodingStyle="http://schemas.xmlsoap.org/soap/encoding/"/>
			</output>
		</operation>
		<% end_loop %>
	</binding>
	<service name="SapphireSOAP_methods">
		<port name="SapphireSOAP_methodsPort" binding="tns:SapphireSOAP_methodsBinding">
			<soap:address location="$CurrentPage.ServiceURL" />
		</port>
	</service>
</definitions>
