<?php header("Content-Type: text/xml; charset=utf-8");
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>"; ?>
<definitions xmlns:soap="http://schemas.xmlsoap.org/wsdl/soap/"
             xmlns:soapenc="http://schemas.xmlsoap.org/soap/encoding/"
             xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
             xmlns:mime="http://schemas.xmlsoap.org/wsdl/mime/"
             xmlns:tns="http://localhost/"
             xmlns:xs="http://www.w3.org/2001/XMLSchema"
             xmlns:soap12="http://schemas.xmlsoap.org/wsdl/soap12/"
             xmlns:http="http://schemas.xmlsoap.org/wsdl/http/"
             name="MyServiceWsdl"
             xmlns="http://schemas.xmlsoap.org/wsdl/"
			 targetNamespace="http://localhost/">
	<!-- Типы данных, используемые в качестве аргументов и возвращаемых значений -->
	<types>
		<xs:schema elementFormDefault="qualified"
                   xmlns:tns="http://schemas.xmlsoap.org/wsdl/"
                   xmlns:xs="http://www.w3.org/2001/XMLSchema"
                   targetNamespace="http://localhost/">				   
				    <xs:element name="Hello_Request">					
						<xs:complexType>
							<!--Объявление формата аргументов сервиса-->
						</xs:complexType>
					</xs:element>
					<xs:element name="Hello_Response">					
						<xs:complexType>
							<xs:sequence>
							<!--Объявление формата возвращаемого значения-->
							<xs:element name="answer" type="xs:string" minOccurs="1" maxOccurs="1"/>
							</xs:sequence>
						</xs:complexType>
					</xs:element>

					<xs:element name="GetSections_Request">					
						<xs:complexType>
							<!--Объявление формата аргументов сервиса-->
						</xs:complexType>
					</xs:element>
					<xs:element name="GetSections_Response">					
						<xs:complexType>
							<xs:sequence>
							<!--Объявление формата возвращаемого значения-->
							<xs:element name="answer" minOccurs="1" maxOccurs="unbounded">
								<xs:complexType>
									<xs:sequence>
										<xs:element name="id" type="xs:int" minOccurs="1" maxOccurs="1"/>
										<xs:element name="value" type="xs:string" minOccurs="1" maxOccurs="1"/>
									</xs:sequence>
								</xs:complexType>
							</xs:element>
							</xs:sequence>
						</xs:complexType>
					</xs:element>	
					
					<xs:element name="GetVacancies_Request">					
						<xs:complexType>
							<xs:sequence>
							<!--Объявление формата аргументов сервиса-->
								<xs:element name="section_id" type="xs:int" minOccurs="1" maxOccurs="1"/>
							</xs:sequence>
						</xs:complexType>
					</xs:element>
					<xs:element name="GetVacancies_Response">					
						<xs:complexType>
							<xs:sequence>
							<!--Объявление формата возвращаемого значения-->
							<xs:element name="answer" minOccurs="1" maxOccurs="unbounded">
								<xs:complexType>
									<xs:sequence>
										<xs:element name="id" type="xs:int" minOccurs="1" maxOccurs="1"/>
										<xs:element name="title" type="xs:string" minOccurs="1" maxOccurs="1"/>
										<xs:element name="date" type="xs:string" minOccurs="1" maxOccurs="1"/>
									</xs:sequence>
								</xs:complexType>
							</xs:element>
							</xs:sequence>
						</xs:complexType>
					</xs:element>
					
					<xs:element name="GetVacancy_Request">					
						<xs:complexType>
							<xs:sequence>
							<!--Объявление формата аргументов сервиса-->
								<xs:element name="id" type="xs:int" minOccurs="1" maxOccurs="1"/>
							</xs:sequence>
						</xs:complexType>
					</xs:element>
					<xs:element name="GetVacancy_Response">					
						<xs:complexType>
							<xs:sequence>
							<!--Объявление формата возвращаемого значения-->
							<xs:element name="answer" minOccurs="1" maxOccurs="1">
								<xs:complexType>
									<xs:sequence>
										<xs:element name="id" type="xs:int" minOccurs="1" maxOccurs="1"/>
										<xs:element name="title" type="xs:string" minOccurs="1" maxOccurs="1"/>
										<xs:element name="content" type="xs:string" minOccurs="1" maxOccurs="1"/>
										<xs:element name="salary" type="xs:int" minOccurs="1" maxOccurs="1"/>
										<xs:element name="experience" type="xs:int" minOccurs="1" maxOccurs="1"/>
										<xs:element name="ismain" type="xs:int" minOccurs="1" maxOccurs="1"/>
										<xs:element name="ispartnership" type="xs:int" minOccurs="1" maxOccurs="1"/>
										<xs:element name="isremote" type="xs:int" minOccurs="1" maxOccurs="1"/>
									</xs:sequence>
								</xs:complexType>
							</xs:element>
							</xs:sequence>
						</xs:complexType>
					</xs:element>
		 </xs:schema>
	</types>
	<!-- Сообщения процедуры  -->
    <message name="Hello_RequestMessage">
        <part name="parameters" element="tns:Hello_Request" />
    </message>
    <message name="Hello_ResponseMessage">
        <part name="parameters" element="tns:Hello_Response" />
    </message>

	<message name="GetSections_RequestMessage">
        <part name="parameters" element="tns:GetSections_Request" />
    </message>
    <message name="GetSections_ResponseMessage">
        <part name="parameters" element="tns:GetSections_Response" />
    </message>
	
	<message name="GetVacancies_RequestMessage">
        <part name="parameters" element="tns:GetVacancies_Request" />
    </message>
    <message name="GetVacancies_ResponseMessage">
        <part name="parameters" element="tns:GetVacancies_Response" />
    </message>
	
	<message name="GetVacancy_RequestMessage">
        <part name="parameters" element="tns:GetVacancy_Request" />
    </message>
    <message name="GetVacancy_ResponseMessage">
        <part name="parameters" element="tns:GetVacancy_Response" />
    </message>
	
	 <!-- Привязка процедуры к сообщениям -->
    <portType name="MyServicePortType">
        <operation name="Hello">
            <input message="tns:Hello_RequestMessage" />
            <output message="tns:Hello_ResponseMessage" />
        </operation>
		
		<operation name="GetSections">
            <input message="tns:GetSections_RequestMessage" />
            <output message="tns:GetSections_ResponseMessage" />
        </operation>
		
		<operation name="GetVacancies">
            <input message="tns:GetVacancies_RequestMessage" />
            <output message="tns:GetVacancies_ResponseMessage" />
        </operation>
		
		<operation name="GetVacancy">
            <input message="tns:GetVacancy_RequestMessage" />
            <output message="tns:GetVacancy_ResponseMessage" />
        </operation>
    </portType>
	<!--Формат процедур веб-сервиса -->
    <binding name="MyServiceBinding" type="tns:MyServicePortType">
        <soap:binding transport="http://schemas.xmlsoap.org/soap/http" />
		<!--Объявление списка процедур-->
        <operation name="Hello">
            <soap:operation soapAction="" />
            <input>
                <soap:body use="literal" />
            </input>
            <output>
                <soap:body use="literal" />
            </output>
        </operation>
		
		<operation name="GetSections">
            <soap:operation soapAction="" />
            <input>
                <soap:body use="literal" />
            </input>
            <output>
                <soap:body use="literal" />
            </output>
        </operation>
		
		<operation name="GetVacancies">
            <soap:operation soapAction="" />
            <input>
                <soap:body use="literal" />
            </input>
            <output>
                <soap:body use="literal" />
            </output>
        </operation>
		
		<operation name="GetVacancy">
            <soap:operation soapAction="" />
            <input>
                <soap:body use="literal" />
            </input>
            <output>
                <soap:body use="literal" />
            </output>
        </operation>
    </binding>
	<!--Определение сервиса -->
    <service name="MyService">
        <port name="MyServicePort" binding="tns:MyServiceBinding">
            <soap:address location="http://job/soapapi/server.php"/>
        </port>
    </service>
</definitions>