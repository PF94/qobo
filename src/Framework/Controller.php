<?php
// Copyright Chaziz Multimedia Entertainment and Bittoco 2024, all rights reserved.

namespace Qobo\Framework;

use \SimpleXMLElement;

use Qobo\App;
use Qobo\Framework\DB;
use Qobo\Framework\Frontend;

/**
 * QoboFramework Controller.
 *
 * This is a base class that you can extend to make a valid controller for your route.
 * @author RGB
 */
class Controller {
    public $db;
    public $frontend;
    public $sbdb;

    public function __construct() {
        $this->db = App::container()->get(DB::class);
        $this->frontend = App::container()->get(Frontend::class);

        // this is shit. i know. -chaziz 5/7/2024
        try {
            $this->sbdb = App::container()->get("sb_db");
        } catch (\Exception $e) {
            $this->sbdb = null;
        }

    }

    public function returnJSON(object $data) {
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    // https://stackoverflow.com/a/5965940 (but modified)
    public function returnXML( $data ) {
        header('Content-Type: application/xml');

        $xml_data = new SimpleXMLElement('<?xml version="1.0"?><data></data>');

        foreach( $data as $key => $value ) {
            if( is_array($value) ) {
                if( is_numeric($key) ){
                    $key = 'item'.$key; //dealing with <0/>..<n/> issues
                }
                $subnode = $xml_data->addChild($key);
                $this->array_to_xml($value, $subnode);
            } else {
                $xml_data->addChild("$key",htmlspecialchars("$value"));
            }
        }

        return $xml_data->asXML();
    }

    public function redirect(string $url) {
        header("Location: " . $url);
        return;
    }
}
