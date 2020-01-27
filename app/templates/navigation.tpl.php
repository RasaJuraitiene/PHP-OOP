<nav>
    <div class="left">
        <?php foreach ($data['left'] ?? [] as $left_id => $link): ?>
            <a href="<?php print $link['url']; ?>" class="nav_butn">
                <?php print $link['title']; ?>
            </a>
        <?php endforeach; ?>
    </div>
    <div class="right">
        <?php foreach ($data['right'] ?? [] as $right_id => $link): ?>
            <a href="<?php print $link['url']; ?>" class="nav_butn">
                <?php print $link['title']; ?>
            </a>
        <?php endforeach; ?>
    </div>
</nav>


