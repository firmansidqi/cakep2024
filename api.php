<?php
/*
------------------------------------------------------------------------------------------------
Parameter yang digunakan, khusus untuk $client_id & $client_secret 
di ganti sesuai dengan yang didapatkan dari subdit JKD
------------------------------------------------------------------------------------------------
*/
$url_base       = 'https://sso.bps.go.id/auth/';
$url_token      = $url_base.'realms/pegawai-bps/protocol/openid-connect/token';
$url_api        = $url_base.'admin/realms/pegawai-bps/users';
$client_id      = '13300-evita-4ed';
$client_secret  = 'ef75e3c8-88d8-4c57-a2a7-7732a924144f';
$metode = $_GET["metode"];
$username = $_GET["username"];

if ($metode == "view"){
    $username = $username . "@bps.go.id";
    $query_search   = '?email=' . $username; //'?username={username}' atau '?email={email pegawai}'
}else if($metode == "list"){
    $query_search   = '?username=' . $username; //'?username={username}' atau '?email={email pegawai}'
}

/*
------------------------------------------------------------------------------------------------
Tahap 1 :
Mendapatkan akses token
------------------------------------------------------------------------------------------------
*/

$ch = curl_init($url_token);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
curl_setopt($ch, CURLOPT_POSTFIELDS,"grant_type=client_credentials");
curl_setopt($ch, CURLOPT_USERPWD, $client_id . ":" . $client_secret);  
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response_token = curl_exec($ch);
if(curl_errno($ch)){
    throw new Exception(curl_error($ch));
}
curl_close ($ch);
$json_token = json_decode($response_token, true);
$access_token = $json_token['access_token'];

/*
------------------------------------------------------------------------------------------------
Tahap 2 :
Mendapatkan data pegawai dengan username tertentu
------------------------------------------------------------------------------------------------
*/

$ch = curl_init($url_api.$query_search);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , 'Authorization: Bearer '.$access_token ));  
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
if(curl_errno($ch)){
    throw new Exception(curl_error($ch));
}
curl_close ($ch);
$json = json_decode($response, true);

if ($metode == "list"){
    $i = 1;
    foreach ($json as $result){
        $myArray['username'] = $result['username'];
        $myArray['email'] = $result['email'];
        $atribut = $result['attributes'];

        $myArray['nama'] = implode(" ",$atribut['attribute-nama']);
        $myArray['foto'] = implode(" ",$atribut['attribute-foto']);
        $myArray['nip'] = implode(" ",$atribut['attribute-nip']);
        $myArray['niplama'] = implode(" ",$atribut['attribute-nip-lama']);
        $myArray['golongan'] = implode(" ",$atribut['attribute-golongan']);
        $myArray['jabatan'] = implode(" ",$atribut['attribute-jabatan']);
        $myArray['organisasi'] = implode(" ",$atribut['attribute-organisasi']);
        $myArray['provinsi'] = implode(" ",$atribut['attribute-provinsi']);
        $myArray['kabupaten'] = implode(" ",$atribut['attribute-kabupaten']);
        $myArray['alamatkantor'] = implode(" ",$atribut['attribute-alamat-kantor']);

        if ($i == 1){
            $arrayPegawai = array($myArray);
            $i++;
        }else{
            array_push($arrayPegawai, $myArray);
        }
    }
    $hasil['status'] = "true";
    $hasil['keyword'] = $username;
    $hasil['jumlah'] = count($arrayPegawai);
    $hasil['data'] = $arrayPegawai;
}else if($metode == "view"){
    if (count($json) == 1){
        $hasil['status'] = "true";
        $hasil['username'] = $json[0]['username'];
        $hasil['email'] = $json[0]['email'];
        $atribut = $json[0]['attributes'];

        $hasil['nama'] = implode(" ",$atribut['attribute-nama']);
        $hasil['foto'] = implode(" ",$atribut['attribute-foto']);
        $hasil['nip'] = implode(" ",$atribut['attribute-nip']);
        $hasil['niplama'] = implode(" ",$atribut['attribute-nip-lama']);
        $hasil['golongan'] = implode(" ",$atribut['attribute-golongan']);
        $hasil['jabatan'] = implode(" ",$atribut['attribute-jabatan']);
        $hasil['organisasi'] = implode(" ",$atribut['attribute-organisasi']);
        $hasil['provinsi'] = implode(" ",$atribut['attribute-provinsi']);
        $hasil['kabupaten'] = implode(" ",$atribut['attribute-kabupaten']);
        $hasil['alamatkantor'] = implode(" ",$atribut['attribute-alamat-kantor']);
    }else{
        $hasil['status'] = "false";
        $hasil['keyword'] = $username;
    }
}

echo json_encode($hasil);
/*

echo "Hasil Pencarian <b>$query_search </b><hr>";
$i=1;
foreach ($json as $result){
    echo "<br>$i : Username : ".$result['username']."<ul>";
    foreach ($result['attributes'] as $key => $value){
        echo "<li><i>".$key."</i>: <br>". $value[0]."</li>";
    }
    echo "</ul>";
    $i++;
   
}
*/

?>
