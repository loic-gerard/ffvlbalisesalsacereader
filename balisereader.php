<?php

include 'framework-jin/jin/launcher.php';
use jin\lang\StringTools;
use jin\log\Debug;


class BaliseReader{
    private $callUrl = 'http://www.balisemeteo.com/depart.php?dept=67';
    private $balises = array(
        'Reinhardsmun' => array(
            'designation' => 'Reinhardmunster',
            'orientation' => null,
            'kmh' => null
        ),
        'Breitenbach' => array(
            'designation' => 'Breitenbac',
            'orientation' => null,
            'kmh' => null
        ),
        'Eckbolsheim' => array(
            'designation' => 'Eckbolsheim',
            'orientation' => null,
            'kmh' => null
        ),
        'Grendelbruch' => array(
            'designation' => 'Grendelbruch',
            'orientation' => null,
            'kmh' => null
        ),
        'J9' => array(
            'designation' => 'J9',
            'orientation' => null,
            'kmh' => null
        ),
        'Schwartzbach' => array(
            'designation' => 'Schwartzbach',
            'orientation' => null,
            'kmh' => null
        )
    );
    
    public function __construct() {
        $this->analyseContent();
    }
    
    public function getBalises(){
        return $this->balises;
    }
    
    public function getBalise($code){
        return $this->balises[$code];
    }
    
    private function analyseContent(){
        libxml_use_internal_errors(true);
 
        $doc = new DOMDocument;
        $doc->loadHTMLFile($this->callUrl);

        $links = $doc->getElementsByTagName('a');
        foreach($links as $l){
            $content = $l->textContent;

            foreach($this->balises AS $bk => $bv){
    
                if(StringTools::len($content) > StringTools::len($bk) &&
                    StringTools::left($content, StringTools::len($bk)) == $bk){
                    //GrendelbruchE 14 km/h
                    $segm = StringTools::explode($content, ' ');
                    if($segm > 1){
                        
                        $this->balises[$bk]['orientation'] = StringTools::right($segm[0], (StringTools::len($segm[0]) - StringTools::len($bk)));
                        $this->balises[$bk]['kmh'] = $segm[2];
                    }
                    
                }
            }
        }
       

    }
}