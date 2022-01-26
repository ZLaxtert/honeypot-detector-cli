<?php 

date_default_timezone_set("Asia/Jakarta");

system("clear");
echo banner();
echo "[+] Enter contract address >> ";
$token = trim(fgets(STDIN));
chain:
echo "
=======[Network]=======
[1] Binance smart chain
[2] Etherium network

[+] Chose number >> ";
$chain = trim(fgets(STDIN));
if(!preg_match("/^[0-9]*$/", $chain)){
    echo "\n\n[!] INPUT NUMBER ONLY [!]\n\n";
    goto chain;
}
if($chain == '1'){
    $net = 'bsc';
}elseif($chain == '2'){
    $net = 'eth';
}else{
    echo "\n\n[!] NOT FOUND [!]\n\n";
    goto chain;
}

$ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://api.banditcoding.xyz/honeypot/?chain=$net&address=$token");

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    $res = curl_exec($ch);
    $json = json_decode($res, TRUE);
    if(strpos($res, '"msg":"Token not compatible with Chain!"')){
        exit("\n\n[!] Token not compatible with network! [!]\n\n");
    }
    if(strpos($res, '"honeypot":"No"')){
        $cek = "✅";
    }else{
        $cek = "❌";
    }

    $net = strtoupper($net);
    $symbol   = $json['data']['symbol'];
    $nameC    = $json['data']['name'];
    $decimal  = $json['data']['decimals'];
    $webC     = $json['data']['officialwebsite'];
    $icon     = $json['data']['icon'];
        $ex = explode("?",$icon);
        $link = $ex[0];
    $pot      = $json['data']['info']['honeypot'];
    $err      = $json['data']['info']['error'];
    $maxtx    = $json['data']['info']['MaxTaxAmount'];
    $maxtxBNB = $json['data']['info']['MaxTxAmountBNB'];
    $buytx    = $json['data']['info']['BuyTax'];
    $selltx   = $json['data']['info']['SellTax'];
    $buygas   = $json['data']['info']['BuyGas'];
    $sellgas  = $json['data']['info']['SellGas'];
    
$result = "

================[Result]================
 NAME             : $nameC
 SYMBOL           : $symbol
 DECIMALS         : $decimal
 WEBSITE          : $webC
 ICON             : $link
 HONEYPOT         : $pot $cek
 NETWORK          : $net
 CONTRACT ADDRESS : $token
 MAX TAX AMOUNT   : $maxtx
 MAX TAX BNB      : $maxtxBNB
 BUY TAX          : $buytx
 SELL TAX         : $selltx
 BUY GAS          : $buygas
 SELL GAS         : $sellgas
========================================

";

system("clear");
echo $result;

function banner(){
    
    $banner = "
 CLI VERSION
  _  _  ___  _  _ _____   _____  ___ _____   ___  ___ _____ ___ ___ _____ ___  ___ 
 | || |/ _ \| \| | __\ \ / / _ \/ _ \_   _| |   \| __|_   _| __/ __|_   _/ _ \| _ \
 | __ | (_) | .` | _| \ V /|  _/ (_) || |   | |) | _|  | | | _| (__  | || (_) |   /
 |_||_|\___/|_|\_|___| |_| |_|  \___/ |_|   |___/|___| |_| |___\___| |_| \___/|_|_\
                                 CODE BY ZLAXTERT
-----------------------------------------------------------------------------------
           Honeypot detector simulates a buy and a sell transaction 
                   to determine if a token is a honeypot.
-----------------------------------------------------------------------------------

";
    return $banner;
}
?>
