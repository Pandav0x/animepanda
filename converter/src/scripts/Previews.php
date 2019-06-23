<?php

namespace App\scripts;

use App\ScriptBase;
use App\Helper\ConsoleProgressBar;

class Previews extends ScriptBase
{
    public function setUp()
    {

    }

    public function execute()
    {
        $dbhandler = $this->database->getInstance();

        $results = $dbhandler->query("SELECT id FROM episode")->fetchAll(\PDO::FETCH_OBJ);
        //dd($results);

        $images = [
            "https://images2.minutemediacdn.com/image/upload/c_crop,h_1193,w_2121,x_0,y_175/f_auto,q_auto,w_1100/v1554921998/shape/mentalfloss/549585-istock-909106260.jpg",
            "https://cdn.thewirecutter.com/wp-content/uploads/2018/07/catadoption-lowres-06052-2x1-1.jpg",
            "https://katu.com/resources/media/5f3693e1-e4d6-4cd3-818f-8cb757743c90-large16x9_CatShow07.jpg",
            "https://www.timesandstar.co.uk/resources/images/9480790.jpg",
            "http://is2.4chan.org/wg/1559502156749.jpg",
            "http://is2.4chan.org/wg/1551690084819.jpg",
            "http://is2.4chan.org/wg/1559494115681.jpg",
            "http://is2.4chan.org/wg/1559491992899.jpg",
            "http://is2.4chan.org/wg/1558978670690.jpg",
            "http://is2.4chan.org/wg/1559419241258.jpg",
            "http://is2.4chan.org/wg/1559501052506.jpg",
            "http://is2.4chan.org/w/1559510348657.png",
            "http://is2.4chan.org/w/1559508296127.jpg",
            "http://is2.4chan.org/w/1559374915276.jpg",
            "http://is2.4chan.org/w/1555756206196.jpg",
            "http://is2.4chan.org/w/1559155584812.jpg",
            "http://is2.4chan.org/w/1529080936772.png",
            "http://is2.4chan.org/w/1559453629758.jpg",
            "http://is2.4chan.org/w/1559478792680.png",
            "http://is2.4chan.org/w/1536169680970.jpg",
            "http://is2.4chan.org/w/1558821728810.jpg",
            "http://is2.4chan.org/w/1550173622540.jpg",
            "http://is2.4chan.org/w/1558665191797.jpg",
            "http://is2.4chan.org/w/1558731910999.jpg",
            "http://is2.4chan.org/w/1559394309249.jpg",
            "http://is2.4chan.org/w/1554960783586.png",
            "http://is2.4chan.org/w/1542322117149.png",
            "http://is2.4chan.org/w/1559420968101.jpg"
        ];

        $videos = [
            "https://media.giphy.com/media/4QxQgWZHbeYwM/giphy.gif",
            "https://media3.giphy.com/media/ErZ8hv5eO92JW/giphy.gif",
            "https://media.giphy.com/media/JXibbAa7ysN9K/giphy.gif",
            "https://media.giphy.com/media/f4V2mqvv0wT9m/giphy.gif",
            "https://media.giphy.com/media/l0IxZkXQw9A7OqbbW/giphy.gif",
            "https://media.giphy.com/media/l0IymZOmiFivJlp5u/giphy.gif",
            "https://media.giphy.com/media/10uSRLBCJVAO1G/giphy.gif",
            "https://media.giphy.com/media/l0Iy0QdzD3AA6bgIg/giphy.gif",
            "https://media.giphy.com/media/2yYx9lggcCcMw/giphy.gif",
            "https://media.giphy.com/media/2KH4IjIQSgqvS/giphy.gif",
            "https://media.giphy.com/media/CglQ2xZD6zxyo/giphy.gif",
            "https://media.giphy.com/media/IzjJJK2UMugWA/giphy.gif"
        ];

        $counter = 0;

        foreach($results as $line)
        {
            $dbhandler->query("UPDATE episode SET thumbnail_image='".$images[$counter%count($images)]."' WHERE id=".$line->id);
            $dbhandler->query("UPDATE episode SET thumbnail_video='".$videos[$counter%count($videos)]."' WHERE id=".$line->id);
            $counter++;
        }
    }

    public function cleanUp()
    {
    }
}
