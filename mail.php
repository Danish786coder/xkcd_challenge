<?php 

include('connection.php');

while(TRUE){
    
//retriveing data with the help of url
$url="https://c.xkcd.com/random/comic/";
$headers=get_headers($url);
$api_url=substr($headers[8],10);
$json_data=file_get_contents($api_url.'/info.0.json');
$response_data=(array)json_decode($json_data);


$image_url=$response_data['img'];


$i=0;
$array_key=array();
foreach ($response_data as $array_key[$i]) {
    $i++;
}

$img="image.png";
if(file_exists($img)){
    unlink($img);
}
file_put_contents($img,file_get_contents($image_url));
$file=$img;


$sql="select * from user_table where subscribe='yes' and status='active' ";
$query=mysqli_query($conn,$sql);
$count=mysqli_num_rows($query);


if($count>0){
    while($row=mysqli_fetch_assoc($query)){
        $token=$row['token'];

// Recipient 
$to = $row['email']; 

 
// Sender 
$from = 'khanfurqankhan123@gmail.com'; 
$fromName = 'xkcd'; 
 
// Email subject 
$subject = 'Detail of Image';  
 

 
// Email body content 
$htmlContent = " 
<h1 style='text-align:center'><img src='$image_url' alt='comic image' width=80% height=400px></h1>
<h1 style='text-align:center'>Details of Image</h1>
<br><strong>Title=</strong>$array_key[5]
<br> <strong>day=</strong>$array_key[10]
<br><strong>Month=</strong>$array_key[0]
<br> <strong>Year=</strong>$array_key[3]
<br><strong> Random Number=</strong>$array_key[1]
<br> <strong>Transcript=</strong>$array_key[6]
<br><br> <strong>alt=</strong>$array_key[7]
<br> <strong>Image Link=</strong>$array_key[8] 
<p><strong>if you do not want to get message then please unsubscribe us by clicking on below unsubscribe button </strong></p>
 <br> <a href='http://localhost/xkcd_challenge/unsubscribe.php?token=$token'><button style='background-color:red; text-align:center'>
 UNSUBSCRIBE</button></a>
"; 
 
// Header for sender info 
$headers = "From: $fromName"." <".$from.">"; 
 
// Boundary  
$semi_rand = md5(time());  
$mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";  
 
// Headers for attachment  
$headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" . " boundary=\"{$mime_boundary}\""; 
 
// Multipart boundary  
$message = "--{$mime_boundary}\n" . "Content-Type: text/html; charset=\"UTF-8\"\n" . 
"Content-Transfer-Encoding: 7bit\n\n" . $htmlContent . "\n\n";  
 
// Preparing attachment 
if(!empty($file) > 0){ 
    if(is_file($file)){ 
        $message .= "--{$mime_boundary}\n"; 
        $fp =    @fopen($file,"rb"); 
        $data =  @fread($fp,filesize($file)); 
 
        @fclose($fp); 
        $data = chunk_split(base64_encode($data)); 
        $message .= "Content-Type: application/octet-stream; name=\"".basename($file)."\"\n" .  
        "Content-Description: ".basename($file)."\n" . 
        "Content-Disposition: attachment;\n" . " filename=\"".basename($file)."\"; size=".filesize($file).";\n" .  
        "Content-Transfer-Encoding: base64\n\n" . $data . "\n\n"; 
    } 
} 
$message .= "--{$mime_boundary}--"; 
$returnpath = "-f" . $from; 

// Send email 
            $mail = @mail($to, $subject, $message, $headers, $returnpath);   

}
}

sleep(300);

}
 
?>

