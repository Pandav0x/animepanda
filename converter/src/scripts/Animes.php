<?php

namespace App\scripts;

use App\ScriptBase;
use App\Helper\ConsoleProgressBar;

class Animes extends ScriptBase
{
    public function setUp()
    {

    }

    public function execute()
    {
        /*$dbhandler = $this->database->getInstance();

        $results = $dbhandler ->query("SELECT * FROM animepandasave.animeurls ORDER BY idanimeurls ASC")->fetchAll(\PDO::FETCH_OBJ);

        $progress =  new ConsoleProgressBar(count($results));

        foreach($results as $anime)
        {
            if($dbhandler->query("SELECT * FROM serie WHERE name='". str_replace('\'', '\\\'', $anime->animename) ."'")->rowCount() == 0)
            {
                $dbhandler->query("INSERT INTO serie (name, synopsis) VALUES ('". $anime->animename ."', 'No synopsis yet')");
                $serieId = $dbhandler->query("SELECT MAX(id) as id FROM serie")->fetchAll(\PDO::FETCH_OBJ)[0]->id;
            }
            else
                $serieId = $dbhandler->query("SELECT id FROM serie WHERE name='". $anime->animename ."'")->fetchAll(\PDO::FETCH_OBJ)[0]->id;

                $episodeNumber = $dbhandler->query("SELECT * FROM episode WHERE serie_id=".$serieId)->rowCount() + 1;

            $dbhandler ->query("INSERT INTO episode (serie_id, number, url) VALUES (".
                $serieId.",".
                $episodeNumber.",".
                "'" . $anime->animeurl . "'".
                ")");

            $progress->progress();
        }*/
    }

    public function cleanUp()
    {
    }
}
