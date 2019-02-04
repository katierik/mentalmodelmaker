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
          console.log("click");
          var num = this.id.match(/\d+/)[0];
          $(".extras").hide();
          $("#extras_" + num).show();
      });
    });
  </script>

    <?php

    /**** Get all the values from the csv file into an array called $csv ****/

    /*Sources from a CSV hosted somewhere else*/
    /*$csv = array_map('str_getcsv', file('https://docs.google.com/spreadsheets/d/e/2PACX-1vQFPTjOD4FoGfQpwBtp5eka2LA-5eVCx6Eo4WKc4NMAqzlBlv1JLCUqOhrKNU9LzHU32cxbtXKFaUOc/pub?output=csv'));*/

    /*Sources from a local CSV file*/
    /*$csv = array_map('str_getcsv', file('data.csv'));*/

/*FOR WORKSHOP ONLY*/
$csv = array_map('str_getcsv', file('https://docs.google.com/spreadsheets/d/e/2PACX-1vT1LiH0EoaKF0pnH2cy8M_g_fJ_-u-sgLfnAwGzXD0giOhn6RZYRfcsd8FAjGXsYcuP5g-skS4CmncV/pub?output=csv'));


    array_walk($csv, function(&$a) use ($csv) {
      $a = array_combine($csv[0], $a);
    });
    array_shift($csv); # remove column header


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
        <div><a href="interviews/AndrewHills/index.html" target="_blank">AH</a></div>
        <div><a href="interviews/EmilNadan_Pt1/index.html" target="_blank">EE</a></div>
        <div><a href="interviews/EmilNadan_Pt2/index.html" target="_blank">EN (some in EE)</a></div>
        <div><a href="interviews/JoeyBoggs/index.html" target="_blank">JB</a></div>
        <div><a href="interviews/MartinPitt/index.html" target="_blank">MP</a></div>
        <div><a href="interviews/MikeMcCormas/index.html" target="_blank">MM</a></div>
        <div><a href="interviews/NellyCredi/index.html" target="_blank">NC</a></div>
        <div><a href="interviews/PaulGallagher/index.html" target="_blank">PG</a></div>
        <div><a href="interviews/RyanHartman/index.html" target="_blank">RH</a></div>
        <div><a href="interviews/VanessaRamos/index.html" target="_blank">VR</a></div>
      </div>
    </div>
    <div class="content">
      <span><?php ?></span>
        <?php
        $x=0;
        /*Number of iterations depends on how many values in the csv*/
        $finalvalue = count($csv);
        $counter = 0;
        while($counter < $finalvalue){
          if($csv[$counter]['Mental Space'] != $csv[($counter-1)]['Mental Space']){
            echo('<div class="mentalspace"><h2>'.$csv[$counter]['Mental Space'].'</h2><div class="contents">');
            $x = $counter;
            while($x <= $finalvalue){
              if($csv[$x]['Mental Space'] == $csv[$counter]['Mental Space']){
                if($csv[$x]['Task tower'] != $csv[($x-1)]['Task tower']){
                  echo('<div class="tower"><h3>'. $csv[$x]['Task tower'] . "</h3>");
                  $y = $x; /*Counter to go through the atomic tasks now*/
                  while($y <= $finalvalue){
                    if($csv[$y]['Task tower'] == $csv[($x)]['Task tower']){
                      echo('<div class="task '. $csv[$y]['CleanType'].'" id="task_'.$csv[$y]['TID'].'">'. $csv[$y]['Atomic task'] . '<div class="extras" id="extras_'.$csv[$y]['TID'].'"><div class="meta"><span> Said by ' . $csv[$y]['ID'] . ' </span><span>| TID: '.$csv[$y]['TID'].'</span></div><span class="quote">'.$csv[$y]['Quote'].'</span></div>' . "</div>");
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
