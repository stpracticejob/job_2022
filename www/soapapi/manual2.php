<?php
$answer = "";
$request_headers = "";
$request_headers .= 'POST $request_url HTTP/1.1'."\r\n";
$request_headers .= "User-Agent: manual2\r\n";
$request_headers .= 'Host: $request_server'."\r\n";
$request_headers .= "Connection: close\r\n";
$request_headers .= "Content-type: text/xml\r\n";
$request_headers .= 'Content-length: $content_length'."\r\n";
$request_headers .= "Accept: */*";

//echo "Page loaded<br/>";
//Если была нажата кнопка "Отправить"
if (isset($_POST["req_go"])) {
    //echo "Go<br/>";
    $request_server = trim($_POST["req_server"]);
    $request_port = (int) $_POST["req_port"];
    $request_url = trim($_POST["req_url"]);
    $request_headers = stripslashes(trim($_POST["req_headers"]));
    $request_xml = stripslashes(trim($_POST["req_xml"]));
    $sock = fsockopen($request_server, $request_port, $errno, $errstr, 30);
    if (!$sock) {
        $answer = "Ошибка создания сокета: \nerrno=$errno\n errstr=$errstr\n";
    } else {
        //echo "Sock opened<br/>";
        //fwrite($sock, "POST $request_url HTTP/1.0\r\n");
        //fwrite($sock, "User-Agent: PHPRPC/1.0\r\n");
        //fwrite($sock, "Host: $request_server\r\n");
        //fwrite($sock, "Content-type: text/xml\r\n");
        //fwrite($sock, "Content-length: " . strlen($request_xml) . "\r\n");
        //fwrite($sock, 'SOAPAction: "http://tempuri.org/IlabSOAP/MyFirstProc"\r\n');
        //fwrite($sock, "Accept: */*\r\n");


        $l = strlen($request_xml);
        //echo "<br/>l=[$l]<br/>";
        //echo "[<xmp>$request_xml</xmp>]";
        $request_headers_p = str_replace('$content_length', $l, $request_headers);
        $request_headers_p = str_replace('$request_url', $request_url, $request_headers_p);
        $request_headers_p = str_replace('$request_server', $request_server, $request_headers_p);

        //echo "<br/>l=[$l]<br/>";
        //echo "request_headers_p <br/> <xmp>[$request_headers_p]</xmp>";
        //$request_headers=$request_headers_p;

        $full_request = "$request_headers_p\r\n\r\n$request_xml\r\n\r\n";

        //echo "full_request[<xmp>";echo $full_request;echo "</xmp>]";
        fwrite($sock, $full_request);
        /*fwrite($sock, $request_headers_p);
        fwrite($sock, "\r\n");
        fwrite($sock, "$request_xml\r\n");
        fwrite($sock, "\r\n");*/

        //Получение заголовков ответа
        $headers = "";
        while ($str = trim(fgets($sock, 4096))) {
            //echo "got $str <br/>";
            $headers .= "$str\n";
        }

        //file_put_contents("manual.log","logging... 100000");
        //Получение тела ответа (XML-данные)
        $data = "";
        while (!feof($sock)) {
            //file_put_contents("manual.log","trying... ",FILE_APPEND);
            $data .= fgets($sock, 4096);
            //$data=fgets($sock , 100000);
                //file_put_contents("manual.log","got [$data]",FILE_APPEND);
        }

        if (!isset($_POST["no_tabs"])) {
            $dom = new DOMDocument();
            $dom->preserveWhiteSpace = false;
            $dom->loadXML($data);
            $dom->formatOutput = true;
            $data = $dom->saveXML();
        }

        $answer = "<textarea style=\"width:50%;height: 90%;\" disabled=\"disabled\">$headers\n\n$data</textarea>";
    }
}
?>

<form action="<?=$_SERVER["PHP_SELF"]?>" method="POST">	
	Хост:<input name="req_server" type="text" size="10" value="<?=$request_server?>"/>
	Порт:<input name="req_port" type="text" size="5" value="<?=$request_port?>"/>
	Путь к сервису:<input name="req_url" type="text" size="60" value="<?=$request_url?>"/><br/>
	<div style="float:left;width:50%">
		<textarea style="width: 100%; height: 15%" name="req_headers"><?=$request_headers?></textarea><br/>
		<textarea style="width: 100%; height: 75%" name="req_xml"><?=$request_xml?></textarea>
		<input name="req_go" type="submit" value="Отправить"/><br/>
	</div>
	<div>
		<?=$answer?><br/>
		<input name="no_tabs" type="checkbox" <?if (isset($_POST["no_tabs"])) {?>checked="1"<?}?>/>не использовать автоформатирование
	</div>	
</form>