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
    curl_setopt($ch, CURLOPT_URL, "https://api.banditcoding.xyz/honeypot/?chain=$net&token=$token");

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
    $pot      = $json['data']['honeypot'];
    $err      = $json['data']['error'];
    $maxtx    = $json['data']['MaxTaxAmount'];
    $maxtxBNB = $json['data']['MaxTxAmountBNB'];
    $buytx    = $json['data']['BuyTax'];
    $selltx   = $json['data']['SellTax'];
    $buygas   = $json['data']['BuyGas'];
    $sellgas  = $json['data']['SellGas'];
    
$result = "

================[Result]================
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
