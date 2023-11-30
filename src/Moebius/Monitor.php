<?php

namespace App\Moebius;

use App\Factory\QueryFactory;

/**
 * Class Definition
 * @package App\Moebius
 */
final class Monitor
{
    private QueryFactory $queryFactory;
    function __construct(QueryFactory $queryFactory)
    {
        $this->queryFactory = $queryFactory;

    }

    public function logLogin(string $ip, string $ua, int $uid){
        $os = explode(";",$ua)[1];
        $array = explode(" ", $ua);
        $browser = end($array);
        $location = $this->retrievePosition($ip);

        $loc = $location->geoplugin_continentName . ", " . $location->geoplugin_countryName. ", " . $location->geoplugin_countryCode.", " . $location->geoplugin_city;


        return $this->queryFactory->newInsert('access_log', [
            'user_id' => $uid,
            'ip' => $ip,
            'browser' => $browser,
            'os' => $os,
            'location' => $loc
        ])->execute();


   }

   function retrievePosition($ip){
       $ch = curl_init();
       curl_setopt($ch, CURLOPT_URL, "http://www.geoplugin.net/json.gp?ip=".$ip);
       curl_setopt($ch, CURLOPT_HTTPHEADER,  array('Content-Type: application/json'));
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
       curl_setopt($ch, CURLOPT_HEADER, FALSE);
       curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
       $result = curl_exec($ch);
       curl_close($ch);
       $params = json_decode($result);
       return $params;
   }

   public function logHackAttempt($ip, $ua, $url){
       $location = $this->retrievePosition($ip);
       $loc = $location->geoplugin_continentName . ", " . $location->geoplugin_countryName. ", " . $location->geoplugin_countryCode.", " . $location->geoplugin_city;


       $this->queryFactory->newInsert('hack_attempt',
        [
            'ip' => $ip,
            'browser' => $ua,
            'location' => $loc,
            'other' => $url
        ]
       )->execute();

   }
}
