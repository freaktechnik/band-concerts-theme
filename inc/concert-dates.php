<ul><?php foreach($concerts as $concert) {
    $entry = '';
    if($concert['fee'] != '-1') {
        $entry = ', Eintritt: '.(empty($concert['fee']) ? 'frei, Kollekte' : $concert['fee'].' CHF');
    } ?>
    <li><time datetime="<?php echo $concert['date'] ?>"><?php echo get_the_date('l j. F Y, H:i', $concert['id']) ?></time> Uhr, <?php echo $concert['location'].$entry ?></li>
<?php } ?>
</ul>
