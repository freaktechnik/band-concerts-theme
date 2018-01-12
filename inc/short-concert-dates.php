<?php
if(count($concerts) == 1) {
    ?><p><?php
    BCTheme::format_details($concerts[0], 'j. F Y', false);
    ?></p><?php
}
else { ?>
<ul><?php foreach($concerts as $concert) { ?>
    <li><?php BCTheme::format_details($concert, 'j. F Y', false); ?></li>
<?php } ?>
</ul>
<?php }
