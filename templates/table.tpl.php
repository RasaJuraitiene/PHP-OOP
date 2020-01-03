<table>
    <thead>
    <tr>
        <?php foreach ($table['thead'] as $col): ?>
            <th><?php print $col; ?></th>
        <?php endforeach; ?>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($table['tbody'] as $row): ?>
        <tr>
            <?php foreach ($row as $col): ?>
                <td><?php print $col; ?></td>
            <?php endforeach; ?>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
