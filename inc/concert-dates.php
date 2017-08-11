<ul><?php foreach($concerts as $concert) { ?>
    <li><time datetime="<?php echo $concert['date'] ?>"><?php echo get_the_date('l j. F Y, H:i', $concert['id']) ?></time> Uhr, <?php echo $concert['location'] ?></li>
<?php } ?>
</ul>
