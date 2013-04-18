<?php

class Shingles {

    private $m = 3;

    function __construct($m=NULL){
        if($m) $this->m= $m;
    }

    public function compare($text1, $text2)
    {

        $match = 0;

        $hash_array1= $this->prepareText($text1);
        $hash_array2= $this->prepareText($text2);

        foreach ($hash_array1 as $hash) {
            if(in_array($hash,$hash_array2)){
                $match++;
            }
        }
        $per = round(($match*100)/(count($hash_array2)-1) ,0);
        if($per>100) $per=100;

        return $per;
    }

    private function prepareText($text)
    {

        $text = trim(preg_replace(array('/\s\s+/', '/[^a-zA-Z0-9\s]/'), array(" ", ""), $text));
        $text_array = explode(" ", $text);
        $shingles = array();
        $shingles_hash = array();

        for ($i = 0; $i < count($text_array) - $this->m+1; $i++) {
            $shingles[] = implode(" ",array_slice($text_array, $i, $this->m));
        }
        foreach ($shingles as $shigle) {
            $shingles_hash[]=crc32($shigle);
        }

        return $shingles_hash;
    }

}