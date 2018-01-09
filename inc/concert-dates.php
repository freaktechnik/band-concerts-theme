<?php
if(count($concerts) == 1) {
    ?><p><?php
    BCTheme::format_details($concerts[0]);
    ?></p><?php
}
else { ?>
<ul><?php foreach($concerts as $concert) { ?>
    <li><?php BCTheme::format_details($concert); ?></li>
<?php } ?>
</ul>
<?php }
