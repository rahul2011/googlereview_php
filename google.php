<?php
/**
 *    google my business review fetch
 *    @category   Javascript
 *    @package    JSON
 *    @author     Rahul [info@goagoaseo.com]
 *    @license    http://www.opensource.org/licenses/bsd-license.php  BSD License
 *    @version    1.0
 */

date_default_timezone_set("Asia/Kolkata");

?>

<!DOCTYPE html>

<html>

<head><title> </title>

<style>

.circle {

 background-repeat: no-repeat;
 background-position: 50%;
 border-radius: 50%;
 width: 90px;
 height: 90px;
}

.profile {
        
 float:left;
 margin : 5px;

}

</style>

</head>

<body>

<?php

$api_key = "xxxxxxxxxxxxxxxxxxxxxxxxxx";  // insert the api key

  /* To get placeId :           

https://maps.googleapis.com/maps/api/place/textsearch/json?key=yourKey&query=guru+technolabs

 placeId will be somewhere in output. :P

*/

$placeid = "xxxxxxxxxxxxxxxxxxxxxxxxxxxxx";  // insert the place id 

$parameters = "key=$api_key&placeid=$placeid";

$url = "https://maps.googleapis.com/maps/api/place/details/json?$parameters";

$cookie="cookies.txt";

           /*****  Using Curl to fetch the data  *****/

           $ch = curl_init();
           curl_setopt ($ch, CURLOPT_URL, $url);
           curl_setopt ($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6");
           curl_setopt ($ch, CURLOPT_TIMEOUT, 60);
           curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 0);
           curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
           curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
           curl_setopt ($ch, CURLOPT_COOKIEJAR, $cookie);
           $result = curl_exec ($ch);
           curl_close($ch);

           /*****  Decode the received json data into php array  *****/

           $res = json_decode($result,true);
		   

           $reviews = ($res['result']['reviews']);

            if(!isset($reviews))

            die();  

            foreach ($reviews as $review) {
				
/*** condition for filter the reviews ***/
if(($review["rating"])>3) 

{
   $dt = new DateTime("@".$review["time"]);   
   $photolink = ($review["profile_photo_url"]);
?>

           <div class="profile">
           <img class="circle" src="<?php echo $photolink; ?>" alt="profile image"> </div>
           <?php
           echo "<b><a href={$review["author_url"]} target='_blank'>{$review["author_name"]}</a></b><br/>"; // print author name
           echo "<span style='color:gray;font-size:10pt'>{$dt->format('d-m-Y')}</span><br/>"; // print date

           for($i=1;$i<=($review["rating"]);$i++)  //print rating
           {
                       echo '<span style="color:red">&#9733;</span>';
           }

           for($i=1;$i<=5-($review["rating"]);$i++)
           {
                   echo '<span style="color:gray">&#9733;</span>';
           }

           echo " {$review["text"]} <br/>";    //print review    
           echo " {$review["relative_time_description"]} <br/>"; // relative_time_description [eg: month a go]
           echo "<br/>";

           echo "<br/> <br/>";

   }

}

?>

</body>

</html>
