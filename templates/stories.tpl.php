<div>
    <ul>
        <?php foreach ($stories as $story): ?>
            <li class="<?php print $story['color']; ?>">
                <?php print $story[0]; ?>
            </li>
        <?php endforeach; ?>
    </ul>
</div>

