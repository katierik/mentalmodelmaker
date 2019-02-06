<html>

  <head>
<!--USAGE NOTES
The CSV needs to be sorted by both mental space and task tower.
If you're in excel/google sheets, sort the task tower column a-z first.
Then sort the mental model column a-z.
Then you should be set to export as CSV.
-->

  <link rel="stylesheet" type="text/css" href="styles.css">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

  <script>
    $(document).ready(function(){
        $(".task").click(function() {
          var num = this.id.match(/\d+/)[0];
          $(".extras").hide();
          $("#extras_" + num).show();
      });

      $("#toggleCpaas").click(function() {
        $(".not_relevant").toggle(); /*Toggle irrelevant task towers */
        $(".No").toggle(); /*Toggle irrelevant tasks */
        $("#relevancyLegend").toggle(); /*Toggle legend of high/med/low */
        $(".High").toggleClass("indicateHigh");
        $(".Med").toggleClass("indicateMed");
        $(".Low").toggleClass("indicateLow");
      });
    });
  </script>

    <?php

    /**** Get all the values from the csv file into an array called $csv ****/

    /*Sources from a CSV hosted somewhere else*/
    /*$csv = array_map('str_getcsv', file('https://docs.google.com/spreadsheets/d/e/2PACX-1vQFPTjOD4FoGfQpwBtp5eka2LA-5eVCx6Eo4WKc4NMAqzlBlv1JLCUqOhrKNU9LzHU32cxbtXKFaUOc/pub?output=csv'));*/

    /*Sources from a local CSV file*/
    $csv = array_map('str_getcsv', file('data.csv'));


    /* Process CSV*/
    array_walk($csv, function(&$a) use ($csv) {
      $a = array_combine($csv[0], $a);
    });
    array_shift($csv); # remove column header

    /* How many items in the CSV */
    $csvcount = count($csv);

    /*Determines if there are tasks marked as relevant in a given task tower */
    function relevantTaskTower($row){
      $y = $row;
      global $csv, $csvcount;
      while($y <= $csvcount){
        if($csv[$y]['Task tower'] === $csv[($row)]['Task tower']){
          if(strcmp($csv[($y)]['IsOurs'],'Yes') == 0){
            return " relevant "; /* returns as soon as it has 1 */
          }
        }
        $y++;
      }
      return " not_relevant ";
    }

    /*Pass back a generated class for the atomic task box */
    function taskClass($row){
      global $csv;
      $timeline = '';

    if(strcmp($csv[($row)]['IsOurs'],'Yes') == 0){
        $timeline = $csv[$row]['Timeline'];
      }

      $taskclass = $csv[$row]['CleanType'] . ' ' . $csv[$row]['IsOurs'] . ' ' . $timeline;

      return $taskclass;
    }

    /*Pass back all the "extras", ID, who is talking, and the quote, for the atomic task box */
    function taskExtras($row){
      global $csv;

      $extrasID = 'extras_' . $csv[$row]['TID'];
      $personSpeaking = '<span> Said by ' . $csv[$row]['ID'] . '</span>';
      $taskID = '<span> | TID: '.$csv[$row]['TID'].'</span>';
      $quote = '<span class="quote">'.$csv[$row]['Quote'].'</span>';

      return '<div class="extras" id="'.$extrasID.'"><div class="meta">'.$personSpeaking.$taskID.'</div>'. $quote .'</div>';

    }

    ?>

  </head>

  <body>
    <h1>Mental Model</h1>
    <div class="settings">
      <div class="legend">
        <h2>Legend</h2>
        <div class="QE">QE</div>
        <div class="PE">Productization Engineer</div>
        <div class="UD">Upstream Dev</div>
        <div class="PM">Product/Program Management</div>
        <div class="RCM">RCM</div>
        <div class="Other">Other</div>
      </div>
      <div class="legend">
        <h2>Transcript links</h2>
        <div><a href="interviews/AndrewHills.html" target="_blank">AH</a></div>
        <div><a href="interviews/EmilNadan_1.html" target="_blank">EE</a></div>
        <div><a href="interviews/EmilNadan_2.html" target="_blank">EN (some in EE)</a></div>
        <div><a href="interviews/JoeyBoggs.html" target="_blank">JB</a></div>
        <div><a href="interviews/MartinPitt.html" target="_blank">MP</a></div>
        <div><a href="interviews/MikeMcCormas.html" target="_blank">MM</a></div>
        <div><a href="interviews/NellyCredi.html" target="_blank">NC</a></div>
        <div><a href="interviews/PaulGallagher.html" target="_blank">PG</a></div>
        <div><a href="interviews/RyanHartman.html" target="_blank">RH</a></div>
        <div><a href="interviews/VanessaRamos.html" target="_blank">VR</a></div>
      </div>
      <button id="toggleCpaas">Toggle CPaaS Relevancy</button>
      <div id="relevancyLegend" class="legend">
        <div class="flex-it">
          <div class="high">High</div>
          <div class="med">Med</div>
          <div class="low">Low</div>
        </div>
      </div>
    </div>
    <div class="content">
      <span><?php ?></span>
        <?php
        $x=0;
        $counter = 0;
        while($counter < $csvcount){
          if($csv[$counter]['Mental Space'] != $csv[($counter-1)]['Mental Space']){
            echo('<div class="mentalspace"><h2>'.$csv[$counter]['Mental Space'].'</h2><div class="contents">');
            $x = $counter;
            while($x <= $csvcount){
              if($csv[$x]['Mental Space'] == $csv[$counter]['Mental Space']){
                if($csv[$x]['Task tower'] != $csv[($x-1)]['Task tower']){
                  echo('<div class="tower' . relevantTaskTower($x) . '"><h3>'. $csv[$x]['Task tower'] . "</h3>");
                  $y = $x; /*Counter to go through the atomic tasks now*/
                  while($y <= $csvcount){
                    if($csv[$y]['Task tower'] == $csv[($x)]['Task tower']){
                      echo('<div class="task ' . taskClass($y) . '" id="task_'.$csv[$y]['TID'].'">'. $csv[$y]['Atomic task']  . taskExtras($y) . "</div>");
                    }
                    $y++;
                  }
                  echo("</div>");/*closing the task tower div*/
                }
              }
              $x++;
            }
            echo("</div></div>");/*closing the mental space div*/
          }

          $counter++;
        }
        ?>


</div>
</body>
</html>
