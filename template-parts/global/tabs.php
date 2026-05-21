<?php $tabs = get_query_var("tabs") ?: false; ?>
<?php if( !$tabs ){
    return;
} ?>

<div class="tabs">
    <?php foreach ($tabs as $index => $tab){ ?>
        <button class="tab <?= $index == 0 ? 'active' : ''; ?>" type="button"><?= $tab["title"] ?></button>
    <?php } ?>
</div>
