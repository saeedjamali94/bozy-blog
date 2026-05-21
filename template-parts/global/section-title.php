<?php $info = get_query_var("info") ?: false; ?>

<div class="section-title <?= $info["extraClass"] ?: "" ?>">
    <div class="bold fs-36 title"><?= $info["title"] ?: "" ?></div>
    <p class="subTitle mt-2 text-white"><?= $info["subtitle"] ?: "" ?></p>
</div>
