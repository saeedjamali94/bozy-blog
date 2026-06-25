<?php $tabs = get_query_var("tabs") ?: false; ?>
<?php if( !$tabs || !is_array($tabs) ){
    return;
} ?>

<div class="tabs">
    <?php foreach ($tabs as $index => $tab){ ?>
        <button class="tab <?= $index == 0 ? 'active' : ''; ?>" type="button" data-id="<?= $tab['data-id'] ?>">
            <?= $tab["title"] ?>
        </button>
    <?php } ?>
</div>
