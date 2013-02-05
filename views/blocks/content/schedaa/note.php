<div id="content_schedaa_note">

    <?php
    if (!isset($a)) {
        $a = new forest\form\A();
        $a->loadFromId($_REQUEST['id']);
    }
    $notes = $a->getNotes();
    $notes->loadAll();
    foreach ($notes->getItems() as $note) :
    ?>
    <div>
        <span>
            <div><?php echo $note->getRawData('nota_descr');?></div>
        </span>
        <span>
            <div><?php echo $note->getData('nota');?></div>
        </span>
        <span>
            <div></div>
        </span>
    </div>
    <?php endforeach; ?>
</div>