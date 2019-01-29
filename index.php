<html>

  <head>
<!--USAGE NOTES
The CSV needs to be sorted by both mental space and task tower.
If you're in excel/google sheets, sort the task tower column a-z first.
Then sort the mental model column a-z.
Then you should be set to export as CSV.

-->


  <style>

  body{
    font-family: 'Overpass', sans-serif;
    color: #292e34;
    font-size:14px;
    padding:16px;
  }

  h2, h3{
    text-align:center;
    line-height:1;
  }

  .content{
    display:flex;
    align-items:flex-start;
  }

  .mentalspace{
    background-color: #fff;
    border: 1px solid #D8D8D8;
    padding:16px;
    margin:8px;
    min-width:250px;
  }

  .tower{
    background-color: #f5f5f5;
    border: 1px solid #D8D8D8;
    padding:16px;
    margin:8px;
  }

  .task{
    background-color: #ededed;
    border: 1px solid #D8D8D8;
    padding:16px;
    margin:8px;
  }

  .QE{background-color: #7DC3E8;}

  .PE{background-color: #A2DA9C;}

  .UD{background-color:#8BB4B9;}

  .PM{background-color:#CBC1FF;}

  .RCM{background-color:#FBE8B6;}

  .Other{background-color:#F4B678;}

  .legend{
    display:flex;
  }

  .legend div{
    padding:8px;
    margin:8px;
  }

  </style>
    <?php

    /* Get all the values from the csv file into an array called $csv */
    /*$csv = array_map('str_getcsv', file('sample.csv'));*/
    $csv = array_map('str_getcsv', file('taskanalysis_1_29.csv'));
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
            echo('<div class="mentalspace"><h2>'.$csv[$counter]['Mental Space']."</h2>");
            $x = $counter;
            while($x <= $finalvalue){
              if($csv[$x]['Mental Space'] == $csv[$counter]['Mental Space']){
                if($csv[$x]['Task tower'] != $csv[($x-1)]['Task tower']){
                  echo('<div class="tower"><h3>'. $csv[$x]['Task tower'] . "</h3>");
                  $y = $x; /*Counter to go through the atomic tasks now*/
                  while($y <= $finalvalue){
                    if($csv[$y]['Task tower'] == $csv[($x)]['Task tower']){
                      echo('<div class="task '. $csv[$y]['CleanType'].'" id="'.$csv[$y]['TID'].'">'. $csv[$y]['Atomic task'] . "</div>");
                    }
                    $y++;
                  }
                  echo("</div>");/*closing the task towner div*/
                }
              }
              $x++;
            }
            echo("</div>");/*closing the mental space div*/
          }

          $counter++;
        }

        ?>
</div>


</body>
</html>
