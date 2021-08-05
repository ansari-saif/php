<?php

// pagination numbring
      isset($_GET["page"]) ? $i = ($_GET["page"] - 1)*$limit+1 : $i = 1;
