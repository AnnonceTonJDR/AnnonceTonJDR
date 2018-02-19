<?php

class Utils
{
    public static function isValidPwd(string $password): bool
    {
        //Si on veut rendre plus compliqué un jour
        //preg_match('#[A-Z]#', $_POST['motDePasse']) < 1 || preg_match('#[0-9]#', $_POST['motDePasse']) < 1 || preg_match('/[^a-zA-Z0-9]+/', $_POST['motDePasse'] < 1))
        return (strlen($password) >= 6);
    }

    /**
     * todo:  link to google api
     * return the latitude and longitude of an adress as per computer by the google API
     * @param $acdress String address to be queried
     * @return array linked array with "lon" the longitude and "lat" the latitude
     */
    public static function adressToCoordinates($address)
    {
        if ($address === 'Internet')
            return ["lat" => 0, "lon" => 0];
        $googleAPIKey = "AIzaSyDtnql0_LAPbI6QU8GTnlShmyJ7QQMSL1Q";
        $address = urlencode($address);
        $url = "https://maps.googleapis.com/maps/api/geocode/json?address={$address}&key=$googleAPIKey";
        // get the json response
        $resp_json = file_get_contents($url);
        $resp = json_decode($resp_json, true);
        if ($resp['status'] == 'OK') {

            // get the important data
            $lati = isset($resp['results'][0]['geometry']['location']['lat']) ? $resp['results'][0]['geometry']['location']['lat'] : "";
            $longi = isset($resp['results'][0]['geometry']['location']['lng']) ? $resp['results'][0]['geometry']['location']['lng'] : "";
            $formatted_address = isset($resp['results'][0]['formatted_address']) ? $resp['results'][0]['formatted_address'] : "";

            return ["lat" => $lati, "lon" => $longi];
        }
        return ["lat" => 0, "lon" => 0];

    }
}