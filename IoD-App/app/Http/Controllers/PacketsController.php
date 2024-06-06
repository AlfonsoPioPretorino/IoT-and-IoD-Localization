<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Models\Packet;
use App\Events\PacketReceiveEvent;
use App\Events\SendFullPacket;


class PacketsController extends Controller
{
    function savePacket(Request $request){
        //error_log($request->getContent());
        //Get packet from the post request received.
        /* $new_packet = new Packet();
        $new_packet->session_id = 0;
        $new_packet->packetcontent = $request->getContent();
        $new_packet->save(); */
        
        //GET Request for packet stored in TTN
        $token = 'NNSXS.7DNCI4GR23B42ST6JW6W6STQ4LNMBO5VDQJIR2I.TQVTVT7SVRRCXOILUXNOZXDNRSN2MLMOMOFGQGQHRWX4F3IUOYAQ';
        $response = Http::withToken($token)->withOptions(['verify'=>false])->get('https://eu1.cloud.thethings.network/api/v3/as/applications/def-gps/packages/storage/uplink_message?order=-received_at&limit=1');
        $packet = $response->getBody()->getContents();
        $pak = json_decode($packet);


        $real_coord = [];
        array_push($real_coord, $pak->result->uplink_message->decoded_payload->latitude);
        array_push($real_coord, $pak->result->uplink_message->decoded_payload->longitude);
        
        //Receive packet form the gateway
        $packet = $request->getContent(); 
        $pak = json_decode($packet); 
        $rssi = intval($pak->rxpk[0]->rssi);

        $id = $pak->rxpk[0]->lsnr;

        //$string = json_decode(preg_replace('~[\r\n]+~', '', $packet));
        //print_r($pak->result->uplink_message->decoded_payload->latitude);
        //event(new PacketReceiveEvent($pak->result->uplink_message->decoded_payload->latitude));
        //event(new PacketReceiveEvent($pak->latitude, $pak->longitude));
        $distance = 0;
        //echo("qua <br>");
        //0mt
        if($rssi>-11){
            //echo("-11 <br>");
            $distance = 0;
        }//25mt (55/25)
        elseif($rssi <= -11 && $rssi > -55){
            //echo("-11 -55 <br>");
            $distance = $rssi / -2.2; 
        }//50mt (65/50)
        elseif($rssi <= -55 && $rssi > -65){
            //echo("-55 -65 <br>");
            $distance = $rssi / -1.3; 
        }//75mt / 100mt  (71/85)
        elseif($rssi <= -65 && $rssi > -71){
            //echo("-65 -71 <br>");
            $distance = $rssi / -0.84; 
        }//150mt (91/150)
        elseif($rssi <= -71 && $rssi > -91){
            //echo("-71 -91 <br>");

            $distance = $rssi / -0.61; 
        }//151+mt ()
        elseif($rssi <= -91){
            //echo("-91<br>");
            $distance = $rssi / -0.41; 
        }

        print_r($distance);
        //lat, long, id, distanza,
        event(new PacketReceiveEvent($real_coord, $id, $distance));


    }

    // Retrieve the last n packets from ttn (unused)
    //print_r(self::getLastLines($packet, 4));
    static function getLastLines($string, $n = 1) {
        $lines = explode("\n", $string);
    
        $lines = array_slice($lines, -$n);
    
        return implode("\n", $lines);
    }


    function triangulate(Request $request){
        error_log($request->dist1);
        $script_path = base_path('resources/scripts/triangulation.py');
        error_log($script_path);
        $command = 'python3 '.$script_path.' '.$request->dist1.' '.$request->dist2.' '.$request->dist3.' '.$request->coordG1[0].' '.$request->coordG1[1].' '.$request->coordG2[0].' '.$request->coordG2[1].' '.$request->coordG3[0].' '.$request->coordG3[1];
        error_log($command);
        exec($command, $output);
        return $output;
    }

    function recive_single_packet(Request $request){
        $packet = $request->getContent(); 
        $pak = json_decode($packet); 
        event(new SendFullPacket($pak));
    }

    function write_single_packet(Request $request){
        $new_packet = new Packet();
        $new_packet->session_id = 0;
        $new_packet->packetcontent = (json_encode(json_decode($request->getContent())->data));
        $new_packet->dist = floatval((json_decode($request->getContent())->dist));
        $new_packet->save();
       /*  error_log(json_decode($request->getContent())->dist);
        dd(json_decode($request->getContent())->data);
 */
    }
    

}
